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

    $query =  " SELECT * FROM vw_repository_star_by_user
                WHERE  user_id = :user_id
                ORDER BY created_at DESC;";

    $stmt = $pdo->prepare($query);

    $userId = htmlspecialchars(strip_tags($_GET['user_id']));

    $stmt->bindParam(':user_id', $userId);

    $stmt->execute();

    $result = $stmt->fetch();

    if ($result) {
        echo json_encode($result);
    } else {
        echo json_encode(array('message' => 'User not found'));        
    }

?>