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

    if (empty($data)) {
        echo json_encode(array("message" => "Invalid Parameters"));
        die();
    }
    
    //clean the data 
    $userName = htmlspecialchars(strip_tags($data->user_name));
    
    //fire sql query
    $query = "SELECT * FROM tbl_user WHERE user_name = :user_name;";
    
    //prepare the query
    $stmt = $pdo->prepare($query);

    //bind the parameters
    $stmt->bindParam(':user_name', $userName);

    //execute the stmt
    $stmt->execute();

    $noOfRows = $stmt->rowCount();
    if($noOfRows > 0){
        echo json_encode(array("message" => "User exists"));
    } else {
        echo json_encode(array("message" => "User does not exists")); 
    }





    
?>