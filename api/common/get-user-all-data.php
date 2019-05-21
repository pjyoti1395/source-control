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

    // get user
    $query = 'SELECT * FROM tbl_user WHERE user_id = :user_id;';

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $user = $stmt->fetch();

    // get repositories
    $query = 'SELECT * FROM tbl_repository WHERE user_id = :user_id;';

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    
    $repositories = $stmt->fetchAll();

    // get followers
    $query = 'SELECT * FROM vw_followers WHERE user_id = :user_id;';

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    
    $followers = $stmt->fetchAll();

    echo json_encode([
        'user' => $user,
        'repositories' => $repositories,
        'followers' => $followers
    ]);

?>