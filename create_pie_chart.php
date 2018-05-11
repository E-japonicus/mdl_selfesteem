<?php for ($i=1; $i < 9; $i++) :?>
<?php
$sql = "SELECT rubric_{$i} as rubric_{$i}_score, count(*) as score_count from {infosysselfesteem_rubric} WHERE infosysselfesteem_id = ? GROUP BY rubric_{$i}";
$overall_records = $DB->get_records_sql($sql, array($infosysselfesteem->id));

$score_0 = $overall_records[0]->score_count;
$score_1 = $overall_records[1]->score_count;
$score_2 = $overall_records[2]->score_count;
$score_3 = $overall_records[3]->score_count;

for ($n=0; $n < 4; $n++) { 
    if (${"score_".$n} === null) {
        ${"score_".$n} = "0";
    }
}

$data_lab = 'labels: ["レベル３", "レベル２", "レベル１"],';
$data_col = 'backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56"],';
$data_val = "data: [{$score_2}, {$score_1}, {$score_0}]";


echo "<br>";
if ($i === 4 or $i === 8) {
    $data_lab = 'labels: ["レベル４","レベル３", "レベル２", "レベル１"],';
    $data_col = 'backgroundColor: ["#32cd32", "#FF6384", "#36A2EB", "#FFCE56"],';
    $data_val = "data: [{$score_3}, {$score_2}, {$score_1}, {$score_0}]";
} elseif ($i === 6) {
    $data_val = "data: [{$score_3}, {$score_2}, {$score_1}]";
}

?>

<script>
var ctx = document.getElementById("rubric_graph_<?php echo $i ?>");
var myPieChart = new Chart(ctx, {
  //グラフの種類
  type: 'pie',
  //データの設定
  data: {
      //データ項目のラベル
      <?php echo $data_lab ?>
      
      //データセット
      datasets: [{
          //背景色
          <?php echo $data_col ?>
          //グラフのデータ
          <?php echo $data_val ?>
      }]
  },
  options: {
	  animation: {
		  animateRotate: false
	  },
	  legend: {
		  reverse: true
	  }
  }
	// 
});
</script>
<?php endfor;?>