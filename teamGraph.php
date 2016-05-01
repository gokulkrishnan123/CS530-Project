<?php
//echo "team data";

?>

<html>
<head>
<a href="teamData.html">View Raw Data</a>
</head>

<?php
require 'NBAdatabase.php';
$teamName = $_GET['team'];
$years = '(';
$counter = 0;
//$arraylength = sizeof($_GET['year']);
if ($_GET['whichStats'] == 'onCourt')
{
	
	$table = 'on_court_stats';
	echo $table;
}
else
{
	$table = 'off_court_stats';

}
/*
foreach($_GET['year'] as $year)
{
	$counter++;
	$years = $years . "'" .$year . "'";
	if ($counter == $arraylength)
	{
		$years = $years . ")";
	}
	else
	{
		$years = $years . ",";
	}
}
*/
if ($table == 'on_court_stats')
{
$stmt = $mysqli->prepare("SELECT * FROM $table AS t, nba_team AS n WHERE n.mascot = '".$teamName."' AND t.teamNo=n.teamNo ORDER BY t.year ");
$test = "SELECT * FROM $table AS t, nba_team AS n WHERE t.teamNo=n.teamNo AND n.mascot = '".$teamName."' AND t.year IN $years";
if(!$stmt){
printf("Query Prep Failed: %s\n", $mysqli->error);
exit;
}
$stmt->execute();
$result = $stmt->get_result();
$yearVec='[,';
$winVec='[,';
$offensiveVec='[,';
$defensiveVec='[,';
$MOV='[,';
while($row = $result->fetch_assoc()){
	//echo "<li>\n";
//	echo htmlspecialchars($row["margin_victory"]);
	$yearVec=$yearVec . htmlspecialchars($row["year"]) . ', ';
	$winVec=$winVec . htmlspecialchars($row["win_percent"]) . ', ';
	$offensiveVec= $offensiveVec  . htmlspecialchars($row["offensive_rating"]) . ', ';
        $MOV=$MOV . htmlspecialchars($row["margin_victory"]) . ', ';
	$defensiveVec=$defensiveVec . htmlspecialchars($row["defensive_rating"]) . ', ';;
//	printf("%s%s%s%s%s\n",
	//	htmlspecialchars($row["mascot"]),
	//	htmlspecialchars($row["year"]),
	//	htmlspecialchars($row["win_percent"]),
	//	htmlspecialchars($row["offensive_rating"]),
	//	htmlspecialchars($row["defensive_rating"])
//	);
	//print_r($row);
//	echo "</tr>\n";
}
//echo "RIGHTHERE";
$yearLength=strlen($yearVec);
$winLength=strlen($winVec);
$movLength=strlen($MOV);
$offensiveLength=strlen($offensiveVec); 
$defensiveLength=strlen($defensiveVec); 
$restWin=substr($winVec, 0, $winVec-2);
$restMOV=substr($MOV, 0, $MOV-2);
$restOffensive=substr($offensiveVec, 0, $offensiveVec-2);
$restDefensive=substr($defensiveVec, 0, $defensiveVec-2);
$rest = substr($yearVec, 0, $yearVec-2);
$yearValues=($rest+']');

//echo "AFTER";
$yearFin=$rest . ',]';
$winFin=$restWin . ',]';
$offensiveFin=$restOffensive . ',]';
$defensiveFin=$restDefensive . ',]';
$movFin=$restMOV . ',]';
//echo $yearFin;
//echo $movFin;
//echo $winFin;
//echo $offensiveFin;
//echo $defensiveFin;
//echo "</tr>\n";
//echo "</ul>\n";
}
else
{
//echo "inside off court";
$stmt = $mysqli->prepare("SELECT * FROM $table AS t, nba_team AS n WHERE n.mascot = '".$teamName."' AND t.teamNo=n.teamNo");
$test = "SELECT * FROM $table AS t, nba_team AS n WHERE t.teamNo=n.teamNo AND n.mascot = '".$teamName."' AND t.year IN $years";
if(!$stmt){
printf("Query Prep Failed: %s\n", $mysqli->error);
exit;
}
$stmt->execute();
$result = $stmt->get_result();

$ticketVec='[,';
$payrollVec='[,';
$percentFullVec='[,';
$maxVec='[,';

while($row = $result->fetch_assoc()){
	$ticketVec=$ticketVec . htmlspecialchars($row["avg_ticket_pricing"]) . ', ';
	$payrollVec=$payrollVec . htmlspecialchars($row["payroll"]) . ', ';
	$percentFullVec=$percentFullVec . htmlspecialchars($row["avg_attendance"]) . ', ';
        $maxVec=$maxVec . htmlspecialchars($row["stadium_capacity"]) . ', ';
	//echo "<li>\n";
//        printf("<td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td>\n",
  //              htmlspecialchars($row["mascot"]),
    //            htmlspecialchars($row["year"]),
      //          htmlspecialchars($row["avg_ticket_pricing"]),
        //        htmlspecialchars($row["payroll"]),
          //      htmlspecialchars($row["stadium_capacity"]),
//		htmlspecialchars($row["avg_attendance"])
  //      );
        //print_r($row);
}
$ticketVec=$ticketVec . ']';
$payrollVec=$payrollVec . ']';
$maxVec=$maxVec . ']';
$percentFullVec=$percentFullVec . ']';
//echo $ticketVec;
//echo $payrollVec;
//echo $percentFullVec;
//echo $maxVec;
$stmt->close();
$winFin=$ticketVec;
$offensiveFin=$percentFullVec;
$defensiveFin=$maxVec;
$movFin=$payrollVec;
}
?>

<html>
<script src="chart.js"></script> 
<div style="height: 100%">
<canvas id="myChart" width="4" height="4"></canvas>
</div>
<div style="height: 100%">
<canvas id="myChart2" width="4" height="4"></canvas>
</div>
<div style="height: 100%">
<canvas id="myChart3" width="4" height="4"></canvas>
</div>
<script>
var win = "<?php echo $winFin ?>";
var array = win.split(',');
console.log(win); 
var win2 = "<?php echo $offensiveFin ?>";
console.log(win2);
var whichTable = "<?php echo $table ?>";
console.log(whichTable);
var label1=' ';
var label2=' ';
var label3=' ';
var label4=' ';
if (whichTable==('off_court_stats')) {
console.log('in off court');
	var label1='Ticket Pricing ($)';
	var label2='Average Attendance';
	var label3='Max Capacity';
	var label4='Payroll ($)';
}
if (whichTable==('on_court_stats')) {
console.log('in on court');
	var label1='Win Percentage';
        var label2='Offensive Rating';
        var label3='Defensive Rating';
        var label4='Margin of Victory';
}
var array2 = win2.split(',');
var win3 = "<?php echo $defensiveFin ?>";
var array3 = win3.split(',');
var win4 = "<?php echo $movFin ?>";
var array4 = win4.split(',');
console.log(array4);
var ctx = document.getElementById("myChart").getContext("2d");
ctx.canvas.width = 25;
ctx.canvas.height = 10;
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["2004", "2005", "2006", "2007", "2008", "2009", "2010", "2011", "2012", "2013", "2014"],
        datasets: [{
           fill: false,
	fullWidth: false,
		 label: label1,
            data: array,
		
        }]
    },
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
var ctx2 = document.getElementById("myChart2").getContext("2d");
ctx2.canvas.width = 25;
ctx2.canvas.height = 10;
var myChart2 = new Chart(ctx2, {
    type: 'line',
    data: {
        labels: ["2004", "2005", "2006", "2007", "2008", "2009", "2010", "2011", "2012", "2013", "2014"],
        datasets: [{
           fill: false,
        fullWidth: false,
	borderColor: "rgba(250,192,192,1)",
                 label: label2,
            data: array2,
        },{
           fill: false,
        fullWidth: false,
borderColor: "rgba(75,250,192,1)",
                 label: label3,
            data: array3,
        }]
    },
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
var ctx3 = document.getElementById("myChart3").getContext("2d");
ctx3.canvas.width = 25;
ctx3.canvas.height = 10;
var myChart3 = new Chart(ctx3, {
    type: 'line',
    data: {
        labels: ["2004", "2005", "2006", "2007", "2008", "2009", "2010", "2011", "2012", "2013", "2014"],
        datasets: [{
           fill: false,
        fullWidth: false,
                 label: label4,
            data: array4,

        }]
    },
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
</html>
