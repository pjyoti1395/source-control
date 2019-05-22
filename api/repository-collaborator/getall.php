<?php

    header("Access-Control-allow-Origin: *");
    header("Content-Type: application/json");

    include_once("../../config/Database.php");

    $dtb = new Database();
    $pdo = $dtb->connect();

    $query = "SELECT * FROM vw_repository_collaborter";

    $stmt = $pdo->prepare($query);

    $stmt->execute();

    echo json_encode($stmt->fetchAll());
?>