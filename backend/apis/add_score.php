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

    $sql = "INSERT INTO players (name, score, duration) VALUES (?,?,?)";
    $query=$mysql->prepare($sql);
    $query->bind_param("sii", $name, $score, $duration); // sii: string int int 
    $query->execute();


    $response = [];
    $response["success"] = true;
    echo json_encode($response);

?>