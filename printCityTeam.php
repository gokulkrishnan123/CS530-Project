<html>

This is where data queried by city will be appear

<?php

require 'NBAdatabase.php';

$city = $_GET['city'];

echo $city;

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
$arraylength = sizeof($_GET['year']);
$years = '(';
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

$yearVec='[,';
$incomeVec='[,';
$populationVec='[,';
$ageVec='[,';
$sexRatioVec='[,';
$housingUnitsVec='[,';
$housingCostVec='[,';


if ($table == 'county_data')
{

$stmt = $mysqli->prepare("SELECT * FROM $table AS t, nba_team AS n WHERE t.cityNo=n.cityNo AND n.teamName = '".$city."' AND t.year IN $years");
$test = "SELECT * FROM $table AS t, nba_team AS n WHERE t.teamNo=n.teamNo AND n.teamName = '".$city."' AND t.year IN $years";
if(!$stmt){
printf("Query Prep Failed: %s\n", $mysqli->error);
exit;
}
$stmt->execute();
$result = $stmt->get_result();
echo "<ul>\n";
echo "<h1>Table: {$table}</h1>";
echo "<table border='1'><tr>";
printf("<td>City Name</td> <td>Year</td> <td>Median Income</td> <td>Population</td> <td>Median Age</td> <td>Male/Female Ratio</td> <td>Housing Units</td> <td>Monthly Housing Cost</td>");
echo "</tr>\n";
$counting = 0;
while($row = $result->fetch_assoc()){
        //echo "<li>\n";
	$counting++;
	//print_r($row);
	$yearVec = $yearVec . $row["year"] . ',';
	$incomeVec = $incomeVec . $row["mediumIncome"] . ',';
	$populationVec = $populationVec . $row["population"] . ',';
	$ageVec = $ageVec . $row["medianAge"] . ',';
	$sexRatioVec = $sexRatioVec . $row["maleFemaleRatio"] . ',';
	$housingUnitsVec = $housingUnitsVec . $row["housingUnits"] . ',';
	$housingCostVec = $housingCostVec . $row["monthlyHousingCost"] . ',';
		
	printf("<td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td>\n",
                htmlspecialchars($row["teamName"]),
                htmlspecialchars($row["year"]),
                htmlspecialchars($row["mediumIncome"]),
                htmlspecialchars($row["population"]),
                htmlspecialchars($row["medianAge"]),
		htmlspecialchars($row["maleFemaleRatio"]),
		htmlspecialchars($row["housingUnits"]),
		htmlspecialchars($row["monthlyHousingCost"])
        );
        //print_r($row);
        echo "</tr>\n";
}
$yearVec = $yearVec . ']';
$incomeVec = $incomeVec . ']';
$populationVec = $populationVec . ']';
$ageVec = $ageVec . ']';
$sexRatioVec = $sexRatioVec . ']';
$housingUnitsVec = $housingUnitsVec . ']';
$housingCostVec = $housingCostVec . ']';

echo "</tr>\n";
//echo "</ul>\n";
}

else
{
$stmt = $mysqli->prepare("SELECT * FROM $table AS t, nba_team AS n WHERE t.cityNo=n.cityNo AND n.teamName = '".$city."' AND t.year IN $years");
$test = "SELECT * FROM $table AS t, nba_team AS n WHERE t.teamNo=n.teamNo AND n.teamName = '".$city."' AND t.year IN $years";
echo $test;
if(!$stmt){
printf("Query Prep Failed: %s\n", $mysqli->error);
exit;
}
$stmt->execute();
$result = $stmt->get_result();
echo "inside";
echo "<ul>\n";
echo "<h1>Table: {$table}</h1>";
echo "<table border='1'><tr>";
printf("<td>City Name</td> <td>Year</td> <td>Median Income</td> <td>Population</td> <td>Median Age</td> <td>Male/Female Ratio</td> <td>Housing Units</td> <td>Monthly Housing Cost</td>");
echo "</tr>\n";
while($row = $result->fetch_assoc()){
        //echo "<li>\n";
        
        $yearVec = $yearVec . $row["year"] . ',';
        $incomeVec = $incomeVec . $row["medianIncome"] . ',';
        $populationVec = $populationVec . $row["population"] . ',';
        $ageVec = $ageVec . $row["medianAge"] . ',';
        $sexRatioVec = $sexRatioVec . $row["maleFemaleRatio"] . ',';
        $housingUnitsVec = $housingUnitsVec . $row["housingUnits"] . ',';
        $housingCostVec = $housingCostVec . $row["monthlyHousingCost"] . ',';


	printf("<td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td>\n",
                htmlspecialchars($row["teamName"]),
                htmlspecialchars($row["year"]),
                htmlspecialchars($row["mediumIncome"]),
                htmlspecialchars($row["population"]),
                htmlspecialchars($row["medianAge"]),
                htmlspecialchars($row["maleFemaleRatio"]),
                htmlspecialchars($row["housingUnits"]),
                htmlspecialchars($row["monthlyHousingCost"])
        );
        //print_r($row);
        echo "</tr>\n";
}
$yearVec = $yearVec . ']';
$incomeVec = $incomeVec . ']';
$populationVec = $populationVec . ']';
$ageVec = $ageVec . ']';
$sexRatioVec = $sexRatioVec . ']';
$housingUnitsVec = $housingUnitsVec . ']';
$housingCostVec = $housingCostVec . ']';

echo "</tr>\n";
}

echo $yearVec;
echo $incomeVec;
echo $populationVec;
echo $ageVec;
echo $sexRatioVec;
echo $housingUnitsVec;
echo $housingCostVec;

$stmt->close();

?>

</html>
