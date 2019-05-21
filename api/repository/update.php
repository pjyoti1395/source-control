<?php

    header("Access-Control-Allow-Origin: *");
    //header("Content-type: application/json");
    header('Access-Control-Allow-Methods:PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once("../../config/Database.php");
    
    $dtb = new Database();
    $pdo = $dtb->connect();    
    
    // reads the file into a string
    $data = json_decode(file_get_contents("php://input"));

    if(empty($data)){
        echo json_encode(array('message' => 'Invalid Parameters'));   
        die();  
    }

    $query = "UPDATE tbl_repository 
              SET  
              user_id = :user_id,
              name = :name,             
              description = :description,             
              language = :language,    
              updated_at = sysdate()      
              WHERE rep_id = :rep_id;";                                                               
              
              
    $stmt = $pdo->prepare($query);      
    
    //clean data   
    $data->rep_id = htmlspecialchars(strip_tags($data->rep_id));    
    $data->user_id = htmlspecialchars(strip_tags($data->user_id));    
    $data->name = htmlspecialchars(strip_tags($data->name));     
    $data->description = htmlspecialchars(strip_tags($data->description));     
    $data->language = htmlspecialchars(strip_tags($data->language));
   
                           
    // bind parameters     
    $stmt->bindParam(':rep_id', $data->rep_id);  
    $stmt->bindParam(':user_id', $data->user_id);  
    $stmt->bindParam(':name', $data->name);     
    $stmt->bindParam(':description', $data->description);     
    $stmt->bindParam(':language', $data->language); 
      
                 
    if($stmt->execute()){         
        $count = $stmt->rowCount();
        if ($count > 0) {
            echo json_encode(array('message' => 'Record Updated'));     
        } else {
            echo json_encode(array('message' => 'Record not Updated'));     
        }
    } else {         
        echo json_encode(array('message' => 'Record not Updated'));     
    } 	  

?>