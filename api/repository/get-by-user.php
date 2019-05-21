<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");

    include_once("../../config/Database.php"); 

    $dtb  = new Database();
    $pdo = $dtb->connect();

    if(empty($_GET['user_id'])){
        echo json_encode(array('message' => 'Invalid Parameters'));   
        die();
    }

    $query = "SELECT * FROM tbl_repository
              WHERE user_id = :user_id;";

    $stmt = $pdo->prepare($query);
    
    $userId = $_GET['user_id'];

    //echo $userId;

    $userId = htmlspecialchars(strip_tags($userId));

    $stmt->bindParam(':user_id', $userId);

    $result = $stmt->execute();

    // fetch using associative array 
    $result = $stmt->fetchAll();   

    if($result){
         echo json_encode($result);
    } 
    else {
         echo json_encode(array('message' => 'Repository not found'));        
    } 

    
?>