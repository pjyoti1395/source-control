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
    $query = 'CALL get_user_summary(:user_id);';

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();  

    $user = $stmt->fetch();
    $stmt->nextRowset();

    $repositories = $stmt->fetchAll();
    $stmt->nextRowset();

    $count = $stmt->fetch();
    $stmt->nextRowset();

    // $countRepository = $stmt->fetch();    
    // $countRepository = $countRepository->count_repository;
    // $stmt->nextRowset();

    // $countStarRepository = $stmt->fetch();    
    // $countStarRepository = $countStarRepository->count_star_repository;
    // $stmt->nextRowset();

    // $countFollowers = $stmt->fetch();    
    // $countFollowers = $countFollowers->count_follower;
    // $stmt->nextRowset();

    // $countFollowing = $stmt->fetch();    
    // $countFollowing = $countFollowing->count_following;
    // $stmt->nextRowset();

    echo json_encode([
        'user' => $user,
        'repositories' => $repositories,
        'count' => [
            'repository' => $count->count_repository,
            'starRepository' => $count->count_star_repository,
            'followers' => $count->count_followers,
            'following' => $count->count_following
        ]        
    ]);

?>