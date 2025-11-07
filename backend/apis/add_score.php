<?php

    include("../connection/connection.php");
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data["name"]) && $data["name"] != "")
    {
        $name=$data["name"];
    }
    else{
        $response = [];
        $response["success"] = false;
        $response["error"] = "Name field is missing";
        echo json_encode($response);
        return;
}
    
    $score=rand(1, 1000);
    $duration=rand(5, 900);
    $penalty=floor($duration/10) * 2; // for each 10 sec remove 2 points
    $fscore = max(0, $score - $penalty);

    $sql = "INSERT INTO players (name, score, duration) VALUES (?,?,?)";
    $query=$mysql->prepare($sql);
    $query->bind_param("sii", $name, $fscore, $duration); // sii: string int int 


    $response = [];
    $response["success"] = true;
    echo json_encode($response);

?>