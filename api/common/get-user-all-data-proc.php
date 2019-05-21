<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");

    include_once("../../config/Database.php");    

    $dtb = new Database();
    $pdo = $dtb->connect();

    if (!isset($_GET['user_id'])) {
        echo json_encode(array('message' => 'User not found'));        
        die();
    }
    
    $user_id = htmlspecialchars(strip_tags($_GET['user_id']));

    // call procedure
    $query = 'CALL get_user_all_data(:user_id);';

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();  

    $user = $stmt->fetch();
    $stmt->nextRowset();

    $repositories = $stmt->fetchAll();
    $stmt->nextRowset();

    $followers = $stmt->fetchAll();    

    echo json_encode([
        'user' => $user,
        'repositories' => $repositories,
        'followers' => $followers
    ]);

?>