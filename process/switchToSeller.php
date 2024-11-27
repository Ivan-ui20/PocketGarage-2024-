<?php
    session_start();
    require_once '../backend/database/db.php';    
    if(!isset($_SESSION['user_id'])) {    
        header("Location: /index.php");
        exit();
    }

    $id = $_GET["id"];

    $stmt = $conn->prepare("SELECT seller_id FROM seller WHERE user_id = ? AND status = 'Approved'");
    $stmt->bind_param("s", $id);
    $stmt->execute();

    $result = $stmt->get_result();
        
    if ($result->num_rows <= 0 ) {
        header("Location: /index.php");
    }    

    $row = $result->fetch_assoc();
    $_SESSION["seller_id"] = $row["seller_id"];

    header("Location: /seller.php");
    exit();

?>