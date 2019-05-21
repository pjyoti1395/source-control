<?php
    
    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");
    header('Access-Control-Allow-Methods:POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once("../../config/Database.php");
    
    $dtb = new  Database();
    $pdo = $dtb->connect();

    $data = json_decode(file_get_contents("php://input"));
    $data->searchtext = htmlspecialchars(strip_tags($data->searchtext));
    $data->searchtext = '%' .  $data->searchtext  . '%';

    $query = "SELECT * FROM tbl_user  WHERE first_name LIKE :searchtext OR
                                                    last_name  LIKE :searchtext OR
                                                    email LIKE :searchtext OR 
                                                    mobile_no LIKE :searchtext";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':searchtext', $data->searchtext);
    
    $stmt->execute();
    
    echo json_encode($stmt->fetchAll());
