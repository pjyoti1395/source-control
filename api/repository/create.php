<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");
    header('Access-Control-Allow-Methods:POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once("../../config/Database.php");
    
    $dtb = new Database();
    $pdo = $dtb->connect(); 

    $data = json_decode(file_get_contents("php://input"));

    if(empty($data)){
        echo json_encode(array('message' => 'Invalid Parameters'));   
        die();  
    }

    $query = "INSERT INTO tbl_repository
              SET 
              user_id = :user_id,
              name = :name,
              description = :description,
              language = :language;";

    $stmt = $pdo->prepare($query);

    $userId = htmlspecialchars(strip_tags($data->user_id));
    $name = htmlspecialchars(strip_tags($data->name));
    $description = htmlspecialchars(strip_tags($data->description));
    $language = htmlspecialchars(strip_tags($data->language));

    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':language', $language);

    

    if($stmt->execute()){
        echo json_encode(array("message" => "Record Inserted"));
    }
    else{
        echo json_encode(array("message" => "Record could not be inserted"));
    }
        
    
?>