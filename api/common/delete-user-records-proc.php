<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: DELETE");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

    include_once("../../config/Database.php");    

    $dtb = new Database();
    $pdo = $dtb->connect();

    if (!isset($_GET['user_id'])) {
        echo json_encode(array('message' => 'User not found'));        
        die();
    }
   
    // call procedure
    $query = 'CALL deleting_user_data(:user_id);';

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    if($stmt->execute()){
        echo json_encode(["message" => "Record Deleted"]);
    }
    else {
        echo json_encode(["message" => "Record not deleted"]);
    }
?>