<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json");


    include("connection.php");
    $data = json_decode(file_get_contents("php://input"), true);

    $name=$data["name"];
    $score=$data["score"];
    $duration=$data["duration"];


    $sql = "INSERT INTO players (name, score, duration) VALUES (?,?,?)";
    $query=$mysql->prepare($sql);
    $query->bind_param("sii", $name, $score, $duration);


    if ($query->execute()) {
    echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }

    $check = $mysql->prepare("SELECT id FROM player WHERE name = ?");
    $check->bind_param("s", $name);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "duplicate"]);
        exit;
    }

?>