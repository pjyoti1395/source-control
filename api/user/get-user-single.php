<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");

    include_once("../../config/Database.php");    

    if (!isset($_GET['user_id'])) {
        echo json_encode(array('message' => 'User not found'));        
        die();
    }

    $dtb = new Database();
    $pdo = $dtb->connect();

    $query = 'SELECT * FROM tbl_user WHERE user_id = :user_id;';

    $stmt = $pdo->prepare($query);

    $user_id = htmlspecialchars(strip_tags($_GET['user_id']));

    $stmt->bindParam(':user_id', $user_id);

    $stmt->execute();

    $result = $stmt->fetch();

    if ($result) {
        echo json_encode($result);
    } else {
        echo json_encode(array('message' => 'User not found'));        
    }

?>