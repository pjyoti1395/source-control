<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");

    include_once("../../config/Database.php");    

    if (!isset($_GET['rep_id'])) {
        echo json_encode(array('message' => 'Invalid Parameters'));        
        die();
    }

    $dtb = new Database();
    $pdo = $dtb->connect();

    $query =  " SELECT      
                            A.id,
                            A.user_id,
                            C.user_name,
                            A.rep_id,
                            B.name AS rep_name,
                            A.created_at,
                            A.privilege
                FROM        tbl_repository_collaborter A
                INNER JOIN  tbl_repository B
                ON          A.rep_id = B.rep_id

                INNER JOIN  tbl_user C  
                ON          A.user_id = C.user_id
                WHERE       A.rep_id = :rep_id;";

    $stmt = $pdo->prepare($query);

    $repositoryId = htmlspecialchars(strip_tags($_GET['rep_id']));

    $stmt->bindParam(':rep_id', $repositoryId);

    $stmt->execute();

    $result = $stmt->fetchAll();

    if ($result) {
        echo json_encode($result);
    } else {
        echo json_encode(array('message' => 'Repository not found'));        
    }

?>