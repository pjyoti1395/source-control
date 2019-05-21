<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");
    header('Access-Control-Allow-Methods:DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once("../../config/Database.php");
    
    $dtb = new Database();
    $pdo = $dtb->connect();    
    
    $query = "DELETE FROM tbl_user WHERE user_id = :user_id";

    $user_id = $_GET['user_id'];

    $stmt = $pdo->prepare($query);

    //clean data 

    $user_id = htmlspecialchars(strip_tags($user_id));

    $stmt->bindParam(':user_id',$user_id);
    

    if($stmt->execute()){
        $count = $stmt->rowCount();
        echo json_encode(array("message" => "Record DELETED"));
    } else {
        echo json_encode(array("message" => "Record NOT DELETED"));
    }

?>