<?php
                                                                                                                                                       
    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once("../../config/Database.php");

    $dtb = new Database();
    $pdo = $dtb->connect();  

    $data = json_decode(file_get_contents("php://input"));

    $userName = htmlspecialchars(strip_tags($data->user_name));
    $oldPassword = htmlspecialchars(strip_tags($data->old_password));
    $newPassword = htmlspecialchars(strip_tags($data->new_password));

    $query = "  SELECT * FROM  tbl_user 
                WHERE user_name = :user_name;";

    $stmt = $pdo->prepare($query);
    
    $stmt->bindParam(':user_name', $userName);

    $stmt->execute();

    // fetching the data from the database and storing it in $user                                                                             
    $user = $stmt->fetch(PDO::FETCH_OBJ);  
    
    if($user == false) {
        echo json_encode(array("message"  => "User does not exists"));
    } 
    else {

        if($user->password == $oldPassword){
            
            $query = "  UPDATE tbl_user
                        SET password = :new_password 
                        WHERE user_name = :user_name";

            $stmt = $pdo->prepare($query);         

            $stmt->bindParam(':user_name', $userName);
            $stmt->bindParam(':new_password', $newPassword);
        
            $result = $stmt->execute();

            if($result){
                echo json_encode(array('message' => 'Password updated'));
            } else {
                echo json_encode(array('message' => 'Password not updated'));
            }
        }
        else{
            echo json_encode(array("message" =>  "Passwords not match"));
        }
    }
       
?>