<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");
    header("Access-Control-Allow-Method-POST");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

    include_once("../../config/Database.php");

    $dtb = new Database();
    $pdo = $dtb->connect();

    $data = json_decode(file_get_contents("php://input"));

    $data->repository_id = htmlspecialchars(strip_tags($data->repository_id));
    $data->user_id = htmlspecialchars(strip_tags($data->user_id));

    $query = " INSERT INTO tbl_repository_star
               SET 
               repository_id = :repository_id,
               user_id = :user_id;"; 

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':repository_id', $data->repository_id);
    $stmt->bindParam(':user_id', $data->user_id);

    if($stmt->execute()){
        $count = $stmt->rowCount();
        if($count > 0){
            echo json_encode(["message" => "Record Inserted"]);
        }
        else{
            echo json_encode(["message" => "Record not Inserted"]);
        }
    }
    else
       echo json_encode(["message" => "Record not Inserted"]);
?>