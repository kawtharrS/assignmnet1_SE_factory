<?php

    include("../connection/connection.php");
    $data = json_decode(file_get_contents("php://input"), true);
    
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Content-Type: application/json; charset=UTF-8");



    $name=$data["name"];
    $score=rand(1, 1000);
    $duration=rand(5, 900);


    $sql = "INSERT INTO players (name, score, duration) VALUES (?,?,?)";
    $query=$mysql->prepare($sql);
    $query->bind_param("sii", $name, $score, $duration); // sii: string int int 


    if ($query->execute()) {
    echo json_encode(["status" => "success"]);
    } else {
        if ($mysql->errno === 1062) {
            echo json_encode(["status" => "duplicate"]);
        } else {
            echo json_encode(["status" => "error"]);
        }
    }


?>