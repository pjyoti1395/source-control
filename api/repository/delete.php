<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");
    header('Access-Control-Allow-Methods:DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once("../../config/Database.php");
    
    $dtb = new Database();
    $pdo = $dtb->connect();    

    if(empty($_GET['rep_id'])){
        echo json_encode(array("message" => "Invalid Parameters"));   
        die();
    }

    $rep_id = $_GET['rep_id'];

    $repId = htmlspecialchars(strip_tags($rep_id));
    
    $query = "DELETE FROM tbl_repository 
              WHERE rep_id = :rep_id;";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':rep_id',$repId);
    
    if($stmt->execute()){         
        $count = $stmt->rowCount();
        if ($count > 0) {
            echo json_encode(array('message' => 'Record Deleted'));     
        } else {
            echo json_encode(array('message' => 'Repository not found'));     
        }
    } else {         
        echo json_encode(array('message' => 'Record not Deleted'));     
    } 	  


?>