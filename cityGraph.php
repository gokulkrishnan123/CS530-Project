<head>
<a href="teamData.html">View Raw Data</a>
</head>


<?php

//echo "city graph appears here";

require 'NBAdatabase.php';

$city = $_GET['city'];

//echo $city;

$medianAge = 0;
$sexRatio = 0;
$medianIncome = 0;
$population = 0;
$housingUnits = 0;

if ($_GET['whichLevel'] == 'county')
{
        $table = 'county_data';
}
else
{
        $table = 'metropolitan_area';
}

$counter = 0;
$incomeVec='[,';
$populationVec='[,';
$ageVec='[,';
$sexRatioVec='[,';
$housingUnitsVec='[,';
$housingCostVec='[,';

if ($table == 'county_data')
{

$stmt = $mysqli->prepare("SELECT * FROM $table AS t, nba_team AS n WHERE n.teamName = '".$city."' AND t.cityNo=n.cityNo ORDER BY t.year ASC");
$test = "SELECT * FROM $table AS t, nba_team AS n WHERE n.teamName = '".$city."' AND t.teamNo=n.teamNo";
if(!$stmt){
printf("Query Prep Failed: %s\n", $mysqli->error);
exit;
}
$stmt->execute();
$result = $stmt->get_result();
$counting = 0;
while($row = $result->fetch_assoc()){
        //echo "<li>\n";
        $counting++;
        //print_r($row);
     
        $incomeVec = $incomeVec . $row["mediumIncome"] . ',';
        $populationVec = $populationVec . $row["population"] . ',';
        $ageVec = $ageVec . $row["medianAge"] . ',';
        $sexRatioVec = $sexRatioVec . $row["maleFemaleRatio"] . ',';
        $housingUnitsVec = $housingUnitsVec . $row["housingUnits"] . ',';
        $housingCostVec = $housingCostVec . $row["monthlyHousingCost"]*12 . ',';

}
$incomeVec = $incomeVec . ']';
$populationVec = $populationVec . ']';
$ageVec = $ageVec . ']';
$sexRatioVec = $sexRatioVec . ']';
$housingUnitsVec = $housingUnitsVec . ']';
$housingCostVec = $housingCostVec . ']';

}

else
{
$stmt = $mysqli->prepare("SELECT * FROM $table AS t, nba_team AS n WHERE t.cityNo=n.cityNo AND n.teamName = '".$city."'  AND t.cityNo=n.cityNo ORDER BY t.year ASC");
$test = "SELECT * FROM $table AS t, nba_team AS n WHERE n.teamName = '".$city."' AND t.teamNo=n.teamNo";
//echo $test;
if(!$stmt){
printf("Query Prep Failed: %s\n", $mysqli->error);
exit;
}
$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_assoc()){
        //echo "<li>\n";

        $incomeVec = $incomeVec . $row["mediumIncome"] . ',';
        $populationVec = $populationVec . $row["population"] . ',';
        $ageVec = $ageVec . $row["medianAge"] . ',';
        $sexRatioVec = $sexRatioVec . ($row["maleFemaleRatio"]/2) . ',';
        $housingUnitsVec = $housingUnitsVec . $row["housingUnits"] . ',';
        $housingCostVec = $housingCostVec . $row["monthlyHousingCost"]*12 . ',';

}

$incomeVec = $incomeVec . ']';
$populationVec = $populationVec . ']';
$ageVec = $ageVec . ']';
$sexRatioVec = $sexRatioVec . ']';
$housingUnitsVec = $housingUnitsVec . ']';
$housingCostVec = $housingCostVec . ']';

}

//echo $incomeVec;
//echo $populationVec;
//echo $ageVec;
//echo $sexRatioVec;
//echo $housingUnitsVec;
//echo $housingCostVec;

$stmt->close();

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
<div style="height: 100%">
<canvas id="myChart4" width="4" height="4"></canvas>
</div>
<script>
var win= "<?php echo $populationVec ?>";
var array = win.split(',');
console.log(win); 
var win2 = "<?php echo $incomeVec ?>";
var array2 = win2.split(',');
var win3 = "<?php echo $housingCostVec ?>";
var array3 = win3.split(',');
var win4 = "<?php echo $ageVec ?>";
var array4 = win4.split(',');
console.log(array4);
var win5 = "<?php echo $sexRatioVec ?>";
var array5 = win5.split(',');
var win6 = "<?php echo $housingUnitsVec ?>";
var array6 = win6.split(',');
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
borderColor: "rgba(250,192,192,1)",
		 label: 'Population',
            data: array,
		
        },
	{
           fill: false,
        fullWidth: false,
borderColor: "rgba(75,250,192,1)",
                 label: 'Housing Units',
            data: array6,

        }
	]
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
                 label: 'Annual Median Income',
            data: array2,
        },{
           fill: false,
        fullWidth: false,
borderColor: "rgba(75,250,192,1)",
                 label: 'Annual Average Housing Cost',
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
                 label: 'Median Age',
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
var ctx4 = document.getElementById("myChart4").getContext("2d");
ctx4.canvas.width = 25;
ctx4.canvas.height = 10;
var myChart4 = new Chart(ctx4, {
    type: 'line',
    data: {
        labels: ["2004", "2005", "2006", "2007", "2008", "2009", "2010", "2011", "2012", "2013", "2014"],
        datasets: [{
           fill: false,
        fullWidth: false,
                 label: 'Male Female Sex Ratio',
            data: array5,

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
