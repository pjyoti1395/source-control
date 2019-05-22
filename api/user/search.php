<?php 

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");
    header('Access-Control-Allow-Methods:POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once("../../config/Database.php");

    $dtb = new  Database();
    $pdo = $dtb->connect();

    $data = json_decode(file_get_contents("php://input"));

    $fn = htmlspecialchars(strip_tags($data->first_name));
    $ln = htmlspecialchars(strip_tags($data->last_name));
    $em = htmlspecialchars(strip_tags($data->email));
    $mn = htmlspecialchars(strip_tags($data->mobile_no));

    $query = "SELECT * FROM tbl_user  WHERE first_name LIKE :first_name OR
              last_name  LIKE :last_name OR
              email LIKE :email OR 
              mobile_no LIKE :mobile_no";
   
    $stmt = $pdo->prepare($query);

    $firstName = '%' . $fn . '%';
    $lastName = '%' . $ln. '%';
    $email = '%' . $em . '%';
    $mobileNo = '%' . $mn . '%';

    $stmt->bindParam(':first_name', $firstName);
    $stmt->bindParam(':last_name',$lastName);
    $stmt->bindParam(':email',$email);
    $stmt->bindParam(':mobile_no',$mobileNo);

    if($stmt->execute()){
         return $stmt->fetchAll();
    }
    printf("Error: %s.\n", $stmt->error); 



?>