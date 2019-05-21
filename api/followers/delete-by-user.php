<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: DELETE");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorizaton, X-Requested-With");

    include_once("../../config/Database.php");

    $dtb = new Database();
    $pdo = $dtb->connect();

    $query = "DELETE FROM tbl_followers 
              WHERE user_id = :user_id AND 
              follower_id = :follower_id;";

    $stmt = $pdo->prepare($query);
    
    $userId = $_GET['user_id'];
    $followerId = $_GET['follower_id'];

    $userId = htmlspecialchars(strip_tags($userId));
    $followerId = htmlspecialchars(strip_tags($followerId));

    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':follower_id', $followerId);

    if($stmt->execute()){
        $count = $stmt->rowCount();
        if($count > 0){
            echo json_encode(array("message" => "Record Deleted"));
        }
    } 
    else {
        echo json_encode(array("message" => "Record Not Deleted"));
    }
  


?>