<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");
    header('Access-Control-Allow-Methods:PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once("../../config/Database.php");
    
    $dtb = new Database();
    $pdo = $dtb->connect();    
    
    // reads the file into a string
    $data = json_decode(file_get_contents("php://input"));
    
    $query = "UPDATE tbl_user SET 
            first_name = :first_name,
            last_name = :last_name,
            user_name = :user_name,
            password = :password,
            email = :email,
            mobile_no = :mobile_no
            WHERE user_id = :user_id";

    $stmt = $pdo->prepare($query);

    //clean data 

    $data->user_id = htmlspecialchars(strip_tags($data->user_id));
    $data->first_name = htmlspecialchars(strip_tags($data->first_name));
    $data->last_name = htmlspecialchars(strip_tags($data->last_name));
    $data->user_name = htmlspecialchars(strip_tags($data->user_name));
    $data->password = htmlspecialchars(strip_tags($data->password));
    $data->email = htmlspecialchars(strip_tags($data->email));
    $data->mobile_no = htmlspecialchars(strip_tags($data->mobile_no));

    // bind parameters

    $stmt->bindParam(':user_id',$data->user_id);
    $stmt->bindParam(':first_name',$data->first_name);
    $stmt->bindParam(':last_name',$data->last_name);
    $stmt->bindParam(':user_name',$data->user_name);
    $stmt->bindParam(':password',$data->password);
    $stmt->bindParam(':email',$data->email);
    $stmt->bindParam(':mobile_no',$data->mobile_no);

    if($stmt->execute()){
        $count = $stmt->rowCount();
        echo json_encode(array('message' => 'Record Updated'));
    } else {
        echo json_encode(array('message' => 'Record not Updated'));
    }

?>