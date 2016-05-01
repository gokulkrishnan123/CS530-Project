<link rel="stylesheet" type="text/css" href="style2.css">
<a href="teamData.html">View Raw Data</a>

<?php

require 'NBAdatabase.php';

$demographic = $_GET['dem'];

$off_court_statistic = $_GET['stat'];

$level = $_GET['dem1level'];

$team = $_GET['team'];

$title = $off_court_statistic . ' vs ' . $demographic;

$stmt = $mysqli->prepare("SELECT $off_court_statistic, $demographic, off_court_stats.year FROM off_court_stats, nba_team, $level WHERE nba_team.mascot = '".$team."' AND nba_team.teamNo = off_court_stats.teamNo AND nba_team.cityNo = $level.cityNo AND off_court_stats.year = $level.year ORDER BY year ASC");


if(!$stmt){
printf("Query Prep Failed: %s\n", $mysqli->error);

exit;
}
$stmt->execute();

$result = $stmt->get_result();

$off_court_vec = '[';
$demographic_vec = '[';

while($row=$result->fetch_assoc())
{
        //$on_court_vec = $on_court_vec . '{' . 'x: ' . $row["$demographic"] . ', ' . 'y: ' . $row["$on_court_statistic"] . ', name: ' .'"'. $        //row["year"].'"'. '},';


        $off_court_vec = $off_court_vec . $row["$off_court_statistic"] . ',';
        $demographic_vec = $demographic_vec . $row["$demographic"] . ',';

}
        $off_court_vec = $off_court_vec . ']';
        $demographic_vec = $demographic_vec . ']';


//$on_court_vec=substr($on_court_vec, 0, $on_court_vec - 2);
//$demographic_vec=substr($demographic_vec, 0, $demographic_vec - 2);

//echo $on_court_vec;
//echo $demographic_vec;
$stmt->close();


?>

<html>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script>
var test = "<?php echo $off_court_vec?>";
var arraytest = test.split(',');
console.log(arraytest);
var demographic ="<?php echo $demographic ?>";
var offCourt ="<?php echo $off_court_statistic ?>";
var test2 = "<?php echo $demographic_vec?>";
var title = "<?php echo $title?>";
var arraytest2 = test2.split(',');
console.log(arraytest2);
  <!-- Plotly.js -->
</script>
  <div id="myDiv" style="width: 480px; height: 400px;"><!-- Plotly chart will be drawn inside this DIV --></div>
  <script>
    <!-- JAVASCRIPT CODE GOES HERE -->
var trace1 = {
  x: arraytest2,
  y: arraytest,
  mode: 'markers+text',
  text: ['2005', '2006', '2007', '2008', '2009', '2010', '2011', '2012', '2013', '2014', '2015'],
  textposition: 'bottom'
};



var data = [ trace1];

var layout = {
  title: title,
  xaxis: {
    title: demographic,
    titlefont: {
      family: 'Courier New, monospace',
      size: 18,
      color: '#7f7f7f'
    }
  },

  yaxis: {
    title: offCourt,
    titlefont: {
      family: 'Courier New, monospace',
      size: 18,
      color: '#7f7f7f'
    }
  }
};
Plotly.newPlot('myDiv', data, layout);
</script>
</html>








