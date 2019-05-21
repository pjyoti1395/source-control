<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");

    include_once("../../config/Database.php");    

    if (!isset($_GET['repository_id'])) {
        echo json_encode(array('message' => 'Repository not found'));        
        die();
    }

    $dtb = new Database();
    $pdo = $dtb->connect();

    $query =  " SELECT * FROM vw_repository_star_by_rep
                WHERE repository_id = :repository_id 
                ORDER BY created_at DESC;";

    $stmt = $pdo->prepare($query);

    $repositoryId = htmlspecialchars(strip_tags($_GET['repository_id']));

    $stmt->bindParam(':repository_id', $repositoryId);

    $stmt->execute();

    $result = $stmt->fetch();

    if ($result) {
        echo json_encode($result);
    } else {
        echo json_encode(array('message' => 'Repository not found'));        
    }

?>