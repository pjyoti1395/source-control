<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");

    include_once("../../config/Database.php");

    $dtb = new Database();
    $pdo = $dtb->connect();

    $query = "SELECT	A.id,
                        A.user_id,
                        B.user_name,
                        A.follower_id,
                        C.user_name AS follower_name,
                        A.created_at
                        FROM tbl_followers AS A

                        INNER JOIN tbl_user AS B
                        ON A.user_id = B.user_id

                        INNER JOIN tbl_user AS C
                        ON A.follower_id = C.user_id

                        ORDER BY A.created_at DESC;";

    $stmt = $pdo->prepare($query);

    $stmt->execute();

    echo json_encode($stmt->fetchAll());
?>