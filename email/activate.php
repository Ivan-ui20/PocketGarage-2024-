<?php


    require_once '../backend/database/db.php';   

    $email = $_GET["email"];
    $status = "Active";
    $stmt = $conn->prepare("UPDATE customer SET status = ? WHERE email_address = ?");
    $stmt->bind_param("ss", $status, $email);
    $stmt->execute();

    $result = $stmt->get_result();
        
    if ($result->num_rows <= 0 ) {
        header("Location: /index.php");
    }    

    header("Location: /index.php");
    exit();



?>
