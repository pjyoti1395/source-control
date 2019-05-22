<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");
    header("Access-Control-Allow-Method-POST");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

    include_once("../../config/Database.php");

    $dtb = new Database();
    $pdo = $dtb->connect();

    $data = json_decode(file_get_contents("php://input"));

    if(!isset($data)){
        echo json_encode(["message" => "Invalid Parameters"]);
        die();
    }
    
    $repId = htmlspecialchars(strip_tags($data->rep_id));
    $userId = htmlspecialchars(strip_tags($data->user_id));
    $privilege = htmlspecialchars(strip_tags($data->privilege));

    $query = "DELETE FROM tbl_repository_collaborter WHERE user_id = :user_id AND rep_id= :rep_id;";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':rep_id', $repId);

    $stmt->execute();      

    $query = "  INSERT INTO tbl_repository_collaborter
                SET
                rep_id = :rep_id,
                user_id = :user_id,
                privilege = :privilege;";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':rep_id', $repId);
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':privilege', $privilege);

    $result = $stmt->execute();

    if($result){
        $count = $stmt->rowCount();
        if($count > 0){
            echo json_encode(["message" => "Record Inserted"]);
        }
        else{
            echo json_encode(["message" => "Record not Inserted"]);
        }
    }
    else
    {
        echo json_encode(["message" => "Record not Inserted"]);
    }


    
   
?>