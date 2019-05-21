<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

    include_once("../../config/Database.php");

    $dtb = new Database();
    $pdo = $dtb->connect();

    $data = json_decode(file_get_contents("php://input"));

    $query = "CALL updating_user_records()";

    $stmt = $pdo->prepare($query);

    $userId = htmlcpecialchars(strip_tags($data->user_id));
    $firstName = htmlcpecialchars(strip_tags($data->user_id));
    $userId = htmlcpecialchars(strip_tags($data->user_id));
    $userId = htmlcpecialchars(strip_tags($data->user_id));
    $userId = htmlcpecialchars(strip_tags($data->user_id));
    $userId = htmlcpecialchars(strip_tags($data->user_id));
    $userId = htmlcpecialchars(strip_tags($data->user_id));
    $userId = htmlcpecialchars(strip_tags($data->user_id));
    $userId = htmlcpecialchars(strip_tags($data->user_id));
    $userId = htmlcpecialchars(strip_tags($data->user_id));
    $userId = htmlcpecialchars(strip_tags($data->user_id));
    $userId = htmlcpecialchars(strip_tags($data->user_id));
    $userId = htmlcpecialchars(strip_tags($data->user_id));

    $stmt->bindParam(':user_id', $user_id);
    if($stmt->execute()){
        echo json_encode(["message" => "Record Deleted"]);
    }
    else {
        echo json_encode(["message" => "Record not deleted"]);
    }

    
?>