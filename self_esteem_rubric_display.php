<?php

include_once './locallib.php';  /* DB */

// submitボタンが押された時
if (isset($_POST['submit'])) {
	
	// POSTされたデータの取り出し
	foreach ($_POST as $name => $value) {
		$$name = $value;
	}

	// POSTされたデータの格納
	$record = new stdClass();
	$record->user_id = $USER->id;
	$record->infosysselfesteem_id = $infosysselfesteem->id;
	for ($i=1; $i < 12; $i++) {
		$record->{"rubric_{$i}"} = optional_param("rubric_{$i}", NULL, PARAM_TEXT);
	}

	if (infosysselfesteem_consider_upsert($record)) {
		// success upsert
	} else {
		// failed
    }	
}

// 今回の結果の読み込み
global $composite_key;
$this_records = $DB->get_record('infosysselfesteem_rubric', $composite_key);

// 前回の結果
$last_sql = 'SELECT * FROM {infosysselfesteem_rubric} WHERE user_id = ? AND infosysselfesteem_id = (SELECT id from {infosysselfesteem} WHERE times < ? ORDER BY times DESC LIMIT 1);';
$last_records = $DB->get_records_sql($last_sql, array($USER->id, $infosysselfesteem->times));
foreach ($last_records as $last_record) {}

// 全体の平均
$overall_sql = 'SELECT AVG(rubric_1) as rubric_1, AVG(rubric_2) as rubric_2, AVG(rubric_3) as rubric_3, AVG(rubric_4) as rubric_4, AVG(rubric_5) as rubric_5, AVG(rubric_6) as rubric_6, 
				AVG(rubric_7) as rubric_7, AVG(rubric_8) as rubric_8, AVG(rubric_9) as rubric_9, AVG(rubric_10) as rubric_10, AVG(rubric_11) as rubric_11 FROM {infosysselfesteem_rubric} WHERE infosysselfesteem_id = ?';
$overall_records = $DB->get_records_sql($overall_sql, array($infosysselfesteem->id));
foreach ($overall_records as $overall_record) {}

include './TJE_average.php';
$this_time_avg = tje_average($this_records);
$last_time_avg = tje_average($last_record);
$overall_avg = tje_average($overall_record);

$rank = array("レベル0", "レベル1", "レベル2", "レベル3");

$consider_recoeds = $DB->get_record('infosysselfesteem_consider', $composite_key);
$def_placeholder = "自己評価が変化した理由を記入してください";
for ($i=1; $i < 12; $i++) { 
	if (isset($consider_recoeds->{"rubric_{$i}"})) {
		$def_placeholder = $consider_recoeds->{"rubric_{$i}"};
	}
}
?>

<link rel="stylesheet" type="text/css" href="./style.css">
<!-- グラフのライブラリの読み込み -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
<!-- ページ遷移制限のためのjQueryの読み込み -->
<script type="text/javascript" src="./javascript/jquery-3.3.1.min.js"></script>

<div>
<h1>レーダーチャート</h1>
<table class="table table-bordered">
	<tbody>
		<tr>
			<td style="text-align:center;" width="40%" rowspan="5"><canvas id="graph_radar" width=“30” height=“30”></canvas></td>
			<td style="text-align:center;" width="10%"></td>
			<th class="table-title" width="10%">今回の得点</th>
			<th class="table-title" width="10%">前回の得点</th>
			<th class="table-title" width="10%">全体の平均</th>
		</tr>
		<tr>
			<th class="table-title">思考力</br>(満点10点)</th>
			<td class="table-val"><?php echo $this_time_avg['think'] ?></td>
			<td class="table-val"><?php echo $last_time_avg['think'] ?></td>
			<td class="table-val"><?php echo $overall_avg['think'] ?></td>
		</tr>
		<tr>
			<th class="table-title">判断力</br>(満点10点)</th>
			<td class="table-val"><?php echo $this_time_avg['judge'] ?></td>
			<td class="table-val"><?php echo $last_time_avg['judge'] ?></td>
			<td class="table-val"><?php echo $overall_avg['judge'] ?></td>
		</tr>
		<tr>
			<th class="table-title">表現力</br>(満点10点)</th>
			<td class="table-val"><?php echo $this_time_avg['expre'] ?></td>
			<td class="table-val"><?php echo $last_time_avg['expre'] ?></td>
			<td class="table-val"><?php echo $overall_avg['expre'] ?></td>
		</tr>
		<tr>
			<th class="table-title">総点</br>(満点30点)</th>
			<td class="table-val"><?php echo $this_time_avg['sum'] ?></td>
			<td class="table-val"><?php echo $last_time_avg['sum'] ?></td>
			<td class="table-val"><?php echo $overall_avg['sum'] ?></td>
		</tr>
	</tbody>
</table>
</div>

<h1>あなたの結果と全体の傾向</h1>
<div style="padding: 20px 0px;">
今回のあなたの結果→<span class="this-time">&emsp;&emsp;</span>
前回のあなたの結果→<span class="last-time">前回</span>
</div>



<div>
<form name="rubric_consider" method="post" action="">
<table class="table table-bordered">
	<tbody>
		<tr>
			<th style="text-align:center" rowspan="2" colspan="2" width="15%">規準</th>
			<th style="text-align:center" colspan="4">基準</th>
			<th style="text-align:center" rowspan="2" width="25%">全体の傾向</th>
		</tr>
		<tr>
			<th style="text-align:center" width="15%">レベル０</th>
			<th style="text-align:center" width="15%">レベル１</th>
			<th style="text-align:center" width="15%">レベル２</th>
			<th style="text-align:center" width="15%">レベル３</th>
		</tr>
		<?php for ($i=1; $i <= 11 ; $i++): ?>
			<tr>
				<th width="2%"><?php echo $i ?>
				<th><?php echo get_string("rubric[{$i}]", 'infosysselfesteem')?></th>
				<?php for ($j=0; $j < 4; $j++) : ?>
				<!-- ルーブリックの取得 -->
				<?php ${"dis_rubric_".$j} = (get_string("rubric[{$i}]_score{$j}", 'infosysselfesteem') === '') ? '' : get_string("rubric[{$i}]_suffix", 'infosysselfesteem').get_string("rubric[{$i}]_score{$j}", 'infosysselfesteem') ?>
				<!-- 今回の結果のセルの色を変える -->
				<?php $this_time_class = ($this_records->{"rubric_{$i}"} === "{$j}") ? 'this-time' : '' ?>
				<!-- 前回の結果のspanを表示 -->
				<?php $last_time_html =  ($last_record->{"rubric_{$i}"} === "{$j}") ? '</br></br><span class="last-time">前回の結果</span>' : '' ?>

				<td class=<?php echo $this_time_class ?>>
					<?php echo ${"dis_rubric_".$j} ?>
					<?php echo $last_time_html ?>
				</td>
				<?php endfor; ?>
				<!-- グラフの描写 -->
				<td><?php echo "<canvas height='180' id='rubric_graph_{$i}'></canvas>"?></td>
			</tr>


			<?php if (!($this_records->{"rubric_{$i}"} === $last_record->{"rubric_{$i}"} or $last_record->{"rubric_{$i}"} === NULL)) : ?>
			<tr class="change_rubric">
			<th colspan="2"><b>規準[<?php echo $i ?>]</b>の自己評価が変化した理由</th>
				<td colspan="5">
				<textarea name="<?php echo "rubric_{$i}"?>" rows="3" style="width:90%" placeholder="自己評価が変化した理由を記入してください" required><?php if (isset($consider_recoeds->{"rubric_{$i}"})) { echo $consider_recoeds->{"rubric_{$i}"}; } ?></textarea>
				</td>
			</tr>
			<?php endif;?>
			
		<?php endfor; ?>
		
	</tbody>
</table>
<button class="submit_button" name="submit">変更を保存する</button>
</form>
</div>

<!-- レーダーチャートの読み込み -->
<?php include_once './create_radar_chart.php' ?>
<!-- 円グラフの読み込み -->
<?php include_once './create_pie_chart.php' ?>

<!-- form入力途中のページ遷移を制限する -->
<script>
$(function(){
var form_change_flg = false;
	window.onbeforeunload = function(e) {
		if (form_change_flg) {
			e.returnValue = "入力画面を閉じようとしています。入力中の情報がありますがよろしいですか？";
		}
	}
    //フォームの内容が変更されたらフラグを立てる
    $("form textarea").change(function() {
  		form_change_flg = true;
  	});
    // フォーム送信時はアラートOFF
    $('form[name=rubric_consider]').submit(function(){
        form_change_flg = false;
    });
});
</script>
