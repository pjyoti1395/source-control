<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");

    include_once("../../config/Database.php"); 

    $dtb  = new Database();
    $pdo = $dtb->connect();

    if(empty($_GET['rep_id'])){
        echo json_encode(array('message' => 'Invalid Parameters'));   
        die();
    }

    $query = "SELECT * FROM tbl_repository
              WHERE rep_id = :rep_id;";

    $stmt = $pdo->prepare($query);
    
    $repId = $_GET['rep_id'];

    $repId = htmlspecialchars(strip_tags($repId));

    $stmt->bindParam(':rep_id', $repId);

    $result = $stmt->execute();

    // fetch using associative array 
    $result = $stmt->fetch();   

    if($result){
         echo json_encode($result);
    } 
    else {
         echo json_encode(array('message' => 'Repository not found'));        
    } 
?>