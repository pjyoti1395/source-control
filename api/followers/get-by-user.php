<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");

    include_once("../../config/Database.php");

    $dtb = new Database();
    $pdo = $dtb->connect();

    $query = "SELECT	A.id,
                        A.user_id,
                        B.user_name,
                        A.follower_id,
                        C.user_name AS follower_name,
                        A.created_at
             FROM       tbl_followers AS A

             INNER JOIN tbl_user AS B
                    ON  A.user_id = B.user_id

             INNER JOIN tbl_user AS C
                     ON A.follower_id = C.user_id
                  WHERE B.user_id = :user_id

               ORDER BY A.created_at DESC;";

    $stmt = $pdo->prepare($query);

    $userId = $_GET['user_id'];

    $userId = htmlspecialchars(strip_tags($userId));

    $stmt->bindParam(':user_id', $userId);

    $result = $stmt->execute();

    $result = $stmt->fetchAll();   

    if($result){
         echo json_encode($result);
    } 
    else {
         echo json_encode(array('message' => 'User does not exist'));        
    } 

?>