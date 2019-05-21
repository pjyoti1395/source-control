<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");

    include_once("../../config/Database.php");

    $dtb = new Database();
    $pdo = $dtb->connect();

    $query = "SELECT * FROM vw_repository_star_all
              ORDER BY created_at DESC;";

    $stmt = $pdo->prepare($query);

    $stmt->execute();

    echo json_encode($stmt->fetchAll());

?>