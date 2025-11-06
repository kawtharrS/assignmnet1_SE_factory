<?php

$db_host = "localhost";
$port = 3310;
$db_user = "root";
$db_pass = "";
$db_name = "fse1";

$mysql = new mysqli($db_host, $db_user, $db_pass, $db_name, $port);

if ($mysql->connect_error) {
    die("Connection failed: " . $mysql->connect_error);
} 

?>
