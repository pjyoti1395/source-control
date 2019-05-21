<?php
    
    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once("../../config/Database.php");

    $dtb = new Database();
    $pdo = $dtb->connect();  

    $data = json_decode(file_get_contents("php://input"));

    $query = "SELECT * FROM  tbl_user
              WHERE user_name = :user_name AND
              password = :password";
    
    //echo $query;

    $stmt = $pdo->prepare($query);

    $data->user_name = htmlspecialchars(strip_tags($data->user_name));
    $data->password = htmlspecialchars(strip_tags($data->password));

    // var_dump($data->user_name);
    // var_dump($data->password);

    $stmt->bindParam(':user_name',$data->user_name);
    $stmt->bindParam(':password',$data->password);

    if($stmt->execute()){
        $count = $stmt->rowCount();
        if ($count > 0) {
            echo json_encode(array('message' => 'Authorised'));
        } else {
            echo json_encode(array('message' => 'Unauthorised'));
        }
        
    } else {
        echo json_encode(array('message' => 'Unauthorised'));
    }