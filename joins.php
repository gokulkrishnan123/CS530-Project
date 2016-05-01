<?php
$dem;//What demographic did they choose?
$stat;//What on or off court stat did they choose?
$stmt = $mysqli->prepare("SELECT $dem, $stat FROM $table AS t, nba_team AS n, metropolitan_area AS m, on_court_stats AS o WHERE n.teamNo=o.teamNo AND m.cityNo=n.cityNo AND n.mascot = '".$teamName."' AND t.teamNo=n.teamNo ORDER BY t.year ");

?>


