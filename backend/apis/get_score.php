<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Content-Type: application/json; charset=UTF-8");

include("../connection/connection.php");

if(isset($_GET["id"]))
{
    $id=$_GET["id"];
}
else 
    $id=-1;

$sql = "SELECT * FROM players";
$query = $mysql->prepare($sql);
$query->execute();

$array = $query->get_result();
$response = [];
while ($article = $array->fetch_assoc()){
    $response[] =$article;
}
echo json_encode($response);


?>