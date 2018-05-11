<?php
$records = $DB->get_records_sql(
    'SELECT A.*, concat({user}.lastname, " ", {user}.firstname) name, {user}.username
    from (select * from {infosysselfesteem_rubric} where infosysselfesteem_id = ?) A 
    inner join {user} on A.user_id = {user}.id
    order by A.user_id',
    array($infosysselfesteem->id));

// infosysselfesteem_formを読み込み
require_once("{$CFG->dirroot}/mod/infosysselfesteem/infosysselfesteem_form.php");
$mform = new infosysselfesteem_form("{$CFG->wwwroot}/mod/infosysselfesteem/view.php?id={$cm->id}");

$rank = array("レベル１", "レベル２", "レベル３", "レベル４");

?>

<link rel="stylesheet" type="text/css" href="./style.css">
<!-- グラフのライブラリの読み込み -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>

<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#charts">全体の傾向</a></li>
  <li><a data-toggle="tab" href="#form">フォーム</a></li>
  <li><a data-toggle="tab" href="#list">ルーブリック登録一覧</a></li>
</ul>

<div class="tab-content">
  

  <div id="charts" class="tab-pane fade in active">
  <?php for ($i=1; $i < 9; $i++) :?>
  <div class="heading"><?php echo get_string("rubric[{$i}]", 'infosysselfesteem')?></div>

	<?php if (!($i === 4 or $i === 6 or $i === 8 )) :?>
	<table class="table table-bordered">
		<tbody>
			<tr>
				<th style="text-align:center" width="60%" colspan="2">基準</th>
				<th style="text-align:center">全体の傾向</th>
			</tr>

			<?php for ($j=0; $j < 3; $j++): ?>
				<tr>
					<th style="text-align:center" width="10%"><?php echo $rank[$j] ?></th>
					<td>
						<?php echo get_string("rubric[{$i}]_suffix", 'infosysselfesteem').get_string("rubric[{$i}]_score{$j}", 'infosysselfesteem')?>
					</td>
					<?php if ($j === 0) { echo "<td rowspan='4'><canvas id='rubric_graph_{$i}'></canvas></td>";}?>
				</tr>
			<?php endfor;?>
			<tr>
				<th style="text-align:center" width="10%">関連する能力</th>
				<td><?php echo get_string("rubric[{$i}]_ability", 'infosysselfesteem')?></td>
			</tr>
		</tbody>
	</table>

	<?php elseif($i === 6):?>
	<table class="table table-bordered">
		<tbody>
			<tr>
				<th style="text-align:center" width="60%" colspan="2">基準</th>
				<th style="text-align:center">全体の傾向</th>
			</tr>

			<?php for ($j=1; $j < 4; $j++): ?>
				<tr>
					<th style="text-align:center" width="10%"><?php echo $rank[$j-1] ?></th>
					<td>
						<?php echo get_string("rubric[{$i}]_suffix", 'infosysselfesteem').get_string("rubric[{$i}]_score{$j}", 'infosysselfesteem')?>
					</td>
					<?php if ($j === 1) { echo "<td rowspan='4'><canvas id='rubric_graph_{$i}'></canvas></td>";}?>
				</tr>
			<?php endfor;?>
			<tr>
				<th style="text-align:center" width="10%">関連する能力</th>
				<td><?php echo get_string("rubric[{$i}]_ability", 'infosysselfesteem')?></td>
			</tr>
		</tbody>
	</table>

	<?php elseif($i === 4 or $i === 8):?>
	<table class="table table-bordered">
		<tbody>
			<tr>
				<th style="text-align:center" width="60%" colspan="2">基準</th>
				<th style="text-align:center">全体の傾向</th>
			</tr>

			<?php for ($j=0; $j < 4; $j++): ?>
				<tr>
					<th style="text-align:center" width="10%"><?php echo $rank[$j] ?></th>
					<td>
						<?php echo get_string("rubric[{$i}]_suffix", 'infosysselfesteem').get_string("rubric[{$i}]_score{$j}", 'infosysselfesteem')?>
					</td>
					<?php if ($j === 0) { echo "<td rowspan='5'><canvas id='rubric_graph_{$i}'></canvas></td>";}?>
				</tr>
			<?php endfor;?>
			<tr>
				<th style="text-align:center" width="10%">関連する能力</th>
				<td><?php echo get_string("rubric[{$i}]_ability", 'infosysselfesteem')?></td>
			</tr>
		</tbody>
	</table>
	<?php endif; ?>

<?php endfor;?>

<?php include_once './create_pie_chart.php' ?>
  
  
  </div>

  <div id="form" class="tab-pane fade">
    <?php $mform->display(); ?>
  </div>

  <div id="list" class="tab-pane fade">
    <span><?php echo count($records); ?>件</span>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>名前</th>
          <th>ユーザ名</th>

          <th>ルーブリック[1]</th>
          <th>ルーブリック[2]</th>
          <th>ルーブリック[3]</th>
          <th>ルーブリック[4]</th>
          <th>ルーブリック[5]</th>
          <th>ルーブリック[6]</th>
          <th>ルーブリック[7]</th>
          <th>ルーブリック[8]</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($records as $record): ?>
          <tr>
            <th><?php echo $record->name      ; ?></th>
            <th><?php echo $record->username  ; ?></th>

            <?php
            for ($i=1; $i < 9; $i++) {
              if ($i === 6) {
                switch ($record->{"rubric_{$i}"}) {
                    case "1":
                        echo "<th>低</th>";
                    break;

                    case "2":
                        echo "<th>中</th>";
                    break;

                    case "3":
                        echo "<th>高</th>";
                    break;

                    case "4":
                        echo "<th>高高</th>";
                    break;
                }
              } else {
                switch ($record->{"rubric_{$i}"}) {
                    case "0":
                        echo "<th>低</th>";
                    break;

                    case "1":
                        echo "<th>中</th>";
                    break;

                    case "2":
                        echo "<th>高</th>";
                    break;

                    case "3":
                        echo "<th>高高</th>";
                    break;
                }
              }
            }
            ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

