<?php
// 今回の結果
$composite_key = array('user_id' => $USER->id, 'infosysselfesteem_id' => $infosysselfesteem->id);
$this_records = $DB->get_record('infosysselfesteem_rubric', $composite_key);

// 前回の結果
$last_sql = 'SELECT * FROM {infosysselfesteem_rubric} WHERE user_id = ? AND infosysselfesteem_id = (SELECT id from {infosysselfesteem} WHERE times < ? ORDER BY times DESC LIMIT 1);';
$last_records = $DB->get_records_sql($last_sql, array($USER->id, $infosysselfesteem->times));
foreach ($last_records as $last_record) {}

// 全体の平均
$overall_sql = 'SELECT AVG(rubric_1) as rubric_1, AVG(rubric_2) as rubric_2, AVG(rubric_3) as rubric_3, AVG(rubric_4) as rubric_4, 
					AVG(rubric_5) as rubric_5, AVG(rubric_6) as rubric_6, AVG(rubric_7) as rubric_7, AVG(rubric_8) as rubric_8 FROM {infosysselfesteem_rubric} WHERE infosysselfesteem_id = ?';
$overall_records = $DB->get_records_sql($overall_sql, array($infosysselfesteem->times));
foreach ($overall_records as $overall_record) {}

include './TJE_average.php';
$this_time_avg = tje_average($this_records);
$last_time_avg = tje_average($last_record);
$overall_avg = tje_average($overall_record);

$rank = array("レベル１", "レベル２", "レベル３", "レベル４");

?>

<link rel="stylesheet" type="text/css" href="./style.css">
<!-- グラフのライブラリの読み込み -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>

<div>
<h1>レーダーチャート</h1>
<table class="table table-bordered">
	<tbody>
		<tr>
			<td style="text-align:center" width="40%" rowspan="5"><canvas id="radar_test_1" width=“30” height=“30”></canvas></td>
			<td style="text-align:center" width="10%"></td>
			<th style="text-align:center" width="10%">今回の得点</th>
			<th style="text-align:center" width="10%">前回の得点</th>
			<th style="text-align:center" width="10%">全体の平均</th>
		</tr>
		<tr>
			<th style="text-align:center">思考力</br>(満点10点)</th>
			<td><?php echo $this_time_avg['think'] ?></td>
			<td><?php echo $last_time_avg['think'] ?></td>
			<td><?php echo $overall_avg['think'] ?></td>
		</tr>
		<tr>
			<th style="text-align:center">判断力</br>(満点10点)</th>
			<td><?php echo $this_time_avg['judge'] ?></td>
			<td><?php echo $last_time_avg['judge'] ?></td>
			<td><?php echo $overall_avg['judge'] ?></td>
		</tr>
		<tr>
			<th style="text-align:center">表現力</br>(満点10点)</th>
			<td><?php echo $this_time_avg['expre'] ?></td>
			<td><?php echo $last_time_avg['expre'] ?></td>
			<td><?php echo $overall_avg['expre'] ?></td>
		</tr>
		<tr>
			<th style="text-align:center" >総点</br>(満点30点)</th>
			<td><?php echo $this_time_avg['sum'] ?></td>
			<td><?php echo $last_time_avg['sum'] ?></td>
			<td><?php echo $overall_avg['sum'] ?></td>
		</tr>
	</tbody>
</table>

</div>

<h1>あなたの結果と全体の傾向</h1>

今回のあなたの結果→<span class="this-time">&emsp;&emsp;</span>
前回のあなたの結果→<span class="last-time">前回</span>

<?php for ($i=1; $i < 9; $i++) :?>
<div class="heading"><?php echo get_string("rubric[{$i}]", 'infosysselfesteem')?></div>

	<?php if (!($i === 4 or $i === 6 or $i === 8 )) :?>
	<table class="table table-bordered">
		<tbody>
			<tr>
				<th style="text-align:center" width="60%" colspan="2">基準</th>
				<th style="text-align:center" width="10%">前回のあなたの結果</th>
				<th style="text-align:center">全体の傾向</th>
			</tr>

			<?php for ($j=0; $j < 3; $j++): ?>
				<tr>
					<th style="text-align:center" width="10%"><?php echo $rank[$j] ?></th>
					<td <?php if ($this_records->{"rubric_{$i}"} === "{$j}") { echo " class='this-time'";}?>>
						<?php echo get_string("rubric[{$i}]_suffix", 'infosysselfesteem').get_string("rubric[{$i}]_score{$j}", 'infosysselfesteem')?>
					</td>
					<?php
						if ($last_record->{"rubric_{$i}"} === "{$j}") {
							echo '<td class="last-time">前回の結果</td>';
						} else {
							echo '<td></td>';
						}
					?>
					<?php if ($j === 0) { echo "<td rowspan='4'><canvas id='rubric_graph_{$i}'></canvas></td>";}?>
				</tr>
			<?php endfor;?>
			<tr>
				<th style="text-align:center" width="10%">関連する能力</th>
				<td colspan="2"><?php echo get_string("rubric[{$i}]_ability", 'infosysselfesteem')?></td>
			</tr>
		</tbody>
	</table>

	<?php elseif($i === 6):?>
	<table class="table table-bordered">
		<tbody>
			<tr>
				<th style="text-align:center" width="60%" colspan="2">基準</th>
				<th style="text-align:center" width="10%">前回のあなたの結果</th>
				<th style="text-align:center">全体の傾向</th>
			</tr>

			<?php for ($j=1; $j < 4; $j++): ?>
				<tr>
					<th style="text-align:center" width="10%"><?php echo $rank[$j-1] ?></th>
					<td <?php if ($this_records->{"rubric_{$i}"} === "{$j}") { echo " class='this-time'";}?>>
						<?php echo get_string("rubric[{$i}]_suffix", 'infosysselfesteem').get_string("rubric[{$i}]_score{$j}", 'infosysselfesteem')?>
					</td>
					<?php
						if ($last_record->{"rubric_{$i}"} === "{$j}") {
							echo '<td class="last-time">前回の結果</td>';
						} else {
							echo '<td></td>';
						}
					?>
					<?php if ($j === 1) { echo "<td rowspan='4'><canvas id='rubric_graph_{$i}'></canvas></td>";}?>
				</tr>
			<?php endfor;?>
			<tr>
				<th style="text-align:center" width="10%">関連する能力</th>
				<td colspan="2"><?php echo get_string("rubric[{$i}]_ability", 'infosysselfesteem')?></td>
			</tr>
		</tbody>
	</table>

	<?php elseif($i === 4 or $i === 8):?>
	<table class="table table-bordered">
		<tbody>
			<tr>
				<th style="text-align:center" width="60%" colspan="2">基準</th>
				<th style="text-align:center" width="10%">前回のあなたの結果</th>
				<th style="text-align:center">全体の傾向</th>
			</tr>

			<?php for ($j=0; $j < 4; $j++): ?>
				<tr>
					<th style="text-align:center" width="10%"><?php echo $rank[$j] ?></th>
					<td <?php if ($this_records->{"rubric_{$i}"} === "{$j}") { echo " class='this-time'";}?>>
						<?php echo get_string("rubric[{$i}]_suffix", 'infosysselfesteem').get_string("rubric[{$i}]_score{$j}", 'infosysselfesteem')?>
					</td>
					<?php
						if ($last_record->{"rubric_{$i}"} === "{$j}") {
							echo '<td class="last-time">前回の結果</td>';
						} else {
							echo '<td></td>';
						}
					?>
					<?php if ($j === 0) { echo "<td rowspan='5'><canvas id='rubric_graph_{$i}'></canvas></td>";}?>
				</tr>
			<?php endfor;?>
			<tr>
				<th style="text-align:center" width="10%">関連する能力</th>
				<td colspan="2"><?php echo get_string("rubric[{$i}]_ability", 'infosysselfesteem')?></td>
			</tr>
		</tbody>
	</table>
	<?php endif; ?>
<?php endfor;?>

<!-- レーダーチャートの読み込み -->
<?php include_once './create_radar_chart.php' ?>
<!-- 円グラフの読み込み -->
<?php include_once './create_pie_chart.php' ?>

