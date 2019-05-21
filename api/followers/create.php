<?php

    header("Access-Control-Allow-Origin: *");
    //header("Content-type: application/json");
    header("Access-Control-Allow-Method-POST");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With");

    include_once("../../config/Database.php");

    $dtb = new Database();
    $pdo = $dtb->connect();

    $data = json_decode(file_get_contents("php://input"));

    if(empty($data)){
        echo json_encode(array('message' => 'Invalid Parameters'));   
        die();  
    }

    $query = "INSERT INTO tbl_followers
              SET 
              user_id = :user_id,
              follower_id = :follower_id,
              created_at = sysdate();";

    $stmt = $pdo->prepare($query);

    $userId = htmlspecialchars(strip_tags($data->user_id));
    $followerId = htmlspecialchars(strip_tags($data->follower_id));
   
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':follower_id', $followerId);
    
    if($stmt->execute()){
        $count = $stmt->rowCount();
        if($count > 0){
            echo json_encode(array("message" => "Record Inserted"));
        }
        else{
            echo json_encode(array("message" => "Record not inserted"));
        }
    }
  
?>