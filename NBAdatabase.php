
<?php
$mysqli = new mysqli('localhost', 'root', 'NBA', 'NBA_demographics');
if ($mysqli->connect_errno)
{
        printf("Connection Failed: %s\n", $mysqli->connect_error);
}
?>

