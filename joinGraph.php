

<?php

require 'NBAdatabase.php';

$demographic = $_GET['dem'];

$on_court_statistic = $_GET['stat'];

$level = $_GET['demlevel'];

$team = $_GET['team'];

$stmt = $mysqli->prepare("SELECT $on_court_statistic, $demographic, on_court_stats.year FROM on_court_stats, nba_team, $level WHERE nba_team.mascot = '".$team."' AND nba_team.teamNo = on_court_stats.teamNo AND nba_team.cityNo = $level.cityNo AND on_court_stats.year = $level.year ORDER BY year ASC");

$test = "SELECT $on_court_statistic, $demographic, on_court_stats.year FROM on_court_stats, nba_team, $level WHERE nba_team.mascot = '".$team."' AND nba_team.teamNo = on_court_stats.teamNo AND nba_team.cityNo = $level.cityNo ORDER BY year ASC";


if(!$stmt){
printf("Query Prep Failed: %s\n", $mysqli->error);

exit;
}
$stmt->execute();

$result = $stmt->get_result();

$on_court_vec = '';
$demographic_vec = '[,';

while($row=$result->fetch_assoc())
{
	$on_court_vec = $on_court_vec . '{' . 'x: ' . $row["$demographic"] . ', ' . 'y: ' . $row["$on_court_statistic"] . ', name: ' .'"'. $row["year"].'"'. '},';
	
}


$on_court_vec=substr($on_court_vec, 0, $on_court_vec - 1);

echo $on_court_vec;

$stmt->close();


?>


<html>
<script src="chart.js"></script> 
<div style="height: 100%">
<canvas id="myChart" width="4" height="4"></canvas>
</div>
<script>
var win = "<?php echo $on_court_vec ?>";
console.log(win);
var array = win.split('},');
console.log(array);
var ctx = document.getElementById("myChart").getContext("2d");
ctx.canvas.width = 25;
ctx.canvas.height = 10;
var myChart = new Chart(ctx, {
        data: [
			{        
				type: "scatter",  
				toolTipContent: "<span style='\"'color: {color};'\"'><strong>{name}</strong></span> <br/> <strong>Cost/ container</strong> {y} $<br/> <strong>Ease of Business</strong> {x} ",
				dataPoints: win,
	}],
    
    options: {
	responsive: true,
	maintainAspectRatio: true,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});


</script>
</html>



