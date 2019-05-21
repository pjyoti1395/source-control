<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");

    include_once("../../config/Database.php");

    $dtb = new Database();
    $pdo = $dtb->connect();

    if (!isset($_GET['rep_id'])) {
        echo json_encode(array('message' => 'Repository not found'));        
        die();
    }

    $rep_id = htmlspecialchars(strip_tags($_GET['rep_id']));

    $query = "CALL get_rep_summary(:rep_id);";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':rep_id', $rep_id);
    $stmt->execute(); 
    
    $repository = $stmt->fetch();
    $stmt->nextRowset();

    $countStarRepository = $stmt->fetch();    
    $countStarRepository = $countStarRepository->count_star_repository;
  

    echo json_encode(["repository" => $repository]);
?>