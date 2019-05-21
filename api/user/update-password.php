<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once("../../config/Database.php");

    $dtb = new Database();
    $pdo = $dtb->connect();

    // read the data that is sent through the post
    $data = json_decode(file_get_contents("php://input"));

    // var_dump(empty($data));
    // var_dump(!isset($data));
    // var_dump($data == null);

    if (empty($data)) {
        echo json_encode(array("message" => "Invalid Parameters"));
        die();
    }

    //clean the data 
    $userName = htmlspecialchars(strip_tags($data->user_name));
    $password = htmlspecialchars(strip_tags($data->password));
   
    $query = "UPDATE tbl_user
              SET password = :password
              WHERE user_name = :user_name;";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':user_name', $userName);
    $stmt->bindParam(':password', $password);

    $stmt->execute();

    $count = $stmt->rowCount();

    if($count > 0){
        echo json_encode(array("message" => "Password Updated"));
    }
    else{
        echo json_encode(array("message" => "Password not Updated"));
    }



?>