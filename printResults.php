<html>
<?php
require 'NBAdatabase.php';
$teamName = $_GET['team'];
$years = '(';
$counter = 0;
$arraylength = sizeof($_GET['year']);
if ($_GET['whichStats'] == 'onCourt')
{
	$table = 'on_court_stats';
}
else
{
	$table = 'off_court_stats';
}
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
if ($table == 'on_court_stats')
{
$stmt = $mysqli->prepare("SELECT * FROM $table AS t, nba_team AS n WHERE t.teamNo=n.teamNo AND n.mascot = '".$teamName."' AND t.year IN $years");
$test = "SELECT * FROM $table AS t, nba_team AS n WHERE t.teamNo=n.teamNo AND n.mascot = '".$teamName."' AND t.year IN $years";
if(!$stmt){
printf("Query Prep Failed: %s\n", $mysqli->error);
exit;
}
$stmt->execute();
$result = $stmt->get_result();
echo "<ul>\n";
echo "<h1>Table: {$table}</h1>";
echo "<table border='1'><tr>";
printf("<td>Team Name</td> <td>Year</td> <td>Win Percentage</td> <td>Offensive Rating</td> <td>Defensive Rating</td>");
echo "</tr>\n";
while($row = $result->fetch_assoc()){
	//echo "<li>\n";
	printf("<td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td>\n",
		htmlspecialchars($row["mascot"]),
		htmlspecialchars($row["year"]),
		htmlspecialchars($row["win_percent"]),
		htmlspecialchars($row["offensive_rating"]),
		htmlspecialchars($row["defensive_rating"])
	);
	//print_r($row);
	echo "</tr>\n";
}
echo "</tr>\n";
//echo "</ul>\n";
}
else
{
//echo "inside off court";
$stmt = $mysqli->prepare("SELECT * FROM $table AS t, nba_team AS n WHERE t.teamNo=n.teamNo AND n.mascot = '".$teamName."' AND t.year IN $years");
$test = "SELECT * FROM $table AS t, nba_team AS n WHERE t.teamNo=n.teamNo AND n.mascot = '".$teamName."' AND t.year IN $years";
if(!$stmt){
printf("Query Prep Failed: %s\n", $mysqli->error);
exit;
}
$stmt->execute();
$result = $stmt->get_result();
echo "<ul>\n";
echo "<h1>Table: {$table}</h1>";
echo "<table border='1'><tr>";
printf("<td>Team Name</td> <td>Year</td> <td>Average Ticket Price</td> <td>Payroll</td> <td>Stadium Capacity</td> <td>Average Attendance</td>");
echo "</tr>\n";
while($row = $result->fetch_assoc()){
        //echo "<li>\n";
        printf("<td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td>\n",
                htmlspecialchars($row["mascot"]),
                htmlspecialchars($row["year"]),
                htmlspecialchars($row["avg_ticket_pricing"]),
                htmlspecialchars($row["payroll"]),
                htmlspecialchars($row["stadium_capacity"]),
		htmlspecialchars($row["avg_attendance"])
        );
        //print_r($row);
        echo "</tr>\n";
}
echo "</tr>\n";
}
$stmt->close()
?>



</html>
