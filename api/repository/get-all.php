<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");

    include_once("../../config/Database.php");    

    $dtb = new Database();
    $pdo = $dtb->connect();

    $query = "SELECT * FROM tbl_repository ORDER BY rep_id DESC;";

    $stmt = $pdo->prepare($query);

    $stmt->execute();

    echo json_encode($stmt->fetchAll());
?>