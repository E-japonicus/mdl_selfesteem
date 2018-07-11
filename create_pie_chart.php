<?php for ($i=1; $i <= 11; $i++) :?>
<?php
$sql = "SELECT rubric_{$i} as rubric_{$i}_score, count(*) as score_count from {infosysselfesteem_rubric} WHERE infosysselfesteem_id = ? GROUP BY rubric_{$i}";
$overall_records = $DB->get_records_sql($sql, array($infosysselfesteem->id));

$score_0 = $overall_records[0]->score_count;
$score_1 = $overall_records[1]->score_count;
$score_2 = $overall_records[2]->score_count;
$score_3 = $overall_records[3]->score_count;

// $score_に値がない時0を代入
for ($n=0; $n < 4; $n++) { 
    if (${"score_".$n} === null) {
        ${"score_".$n} = "0";
    }
}

if (!empty(get_string("rubric[{$i}]_score3", 'infosysselfesteem')) && !empty(get_string("rubric[{$i}]_score0", 'infosysselfesteem'))) {
    // score0~3が存在するルーブリックの場合
    $data_lab = 'labels: ["レベル3","レベル2", "レベル1", "レベル0"],';
    $data_col = 'backgroundColor: ["#32cd32", "#FF6384", "#36A2EB", "#FFCE56"],';
    $data_val = "data: [{$score_3}, {$score_2}, {$score_1}, {$score_0}]";
} elseif (!empty(get_string("rubric[{$i}]_score3", 'infosysselfesteem')) && empty(get_string("rubric[{$i}]_score0", 'infosysselfesteem'))){
    // score3が存在し，score0が存在しないルーブリックの場合
    $data_lab = 'labels: ["レベル3", "レベル2", "レベル1"],';
    $data_col = 'backgroundColor: ["#32cd32", "#FF6384", "#36A2EB"],';
    $data_val = "data: [{$score_3}, {$score_2}, {$score_1}]";
} else {
    // それ以外のルーブリックの場合
    $data_lab = 'labels: ["レベル2", "レベル1", "レベル0"],';
    $data_col = 'backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56"],';
    $data_val = "data: [{$score_2}, {$score_1}, {$score_0}]";
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