<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");
    header("Access-Control-Allow-Method-POST");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

    include_once("../../config/Database.php");

    $dtb = new Database();
    $pdo = $dtb->connect();

    $userId = $_GET['user_id'];
    $repositoryId = $_GET['repository_id'];

    $userId = htmlspecialchars(strip_tags($userId));
    $repositoryId = htmlspecialchars(strip_tags($repositoryId));

    $query = "DELETE FROM tbl_repository_star
              WHERE user_id = :user_id 
              AND repository_id = :repository_id;";

    $stmt = $pdo->prepare($query);
    
    $stmt->bindParam('user_id', $userId);
    $stmt->bindParam('repository_id', $repositoryId);

    if($stmt->execute()){
        $count = $stmt->rowCount();
        if($count > 0){
            echo json_encode(["message" => "Record Deleted"]);
        }
        else {
            echo json_encode(["message" => "Record not Deleted"]);
        }
    }else{
        echo json_encode(["message" => "Record not Deleted"]);
    }

    
    
?>