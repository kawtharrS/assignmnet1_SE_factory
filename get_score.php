<?php
include("connection.php");

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