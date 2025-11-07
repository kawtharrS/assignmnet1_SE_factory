<?php

    include("../connection/connection.php");

    $sql = "SELECT * FROM players ORDER BY score DESC limit 5 ";
    $query = $mysql->prepare($sql);
    $query->execute();

    $array = $query->get_result();
    $response = [];
    $response["success"] = true;
    $response["data"] = [];
    while ($article = $array->fetch_assoc()){
        $response["data"][] = $article;
    }
    echo json_encode($response);


?>