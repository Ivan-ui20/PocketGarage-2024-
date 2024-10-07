<?php

    
    function login($connect, $email, $password) {
        try {
            $stmt = $connect->prepare("SELECT * from seller WHERE email_address = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            
            $userExist = $stmt->get_result();

            if ($userExist->num_rows <= 0 ) {
                return array("title" => "Failed", "message" => "Incorrect email and password", "data" => []);
            }

            $row = $userExist->fetch_assoc();

            if (!password_verify($password, $row['password'])) {                
                return array("title" => "Failed", "message" => "Incorrect Password. Please try again", "data" => []);
            }

            return array("title" => "Success", "message" => "Login Successful", "data" => []);
        } catch (\Throwable $th) {
            
            return array("title" => "Failed", "message" => "Something went wrong!", "data" => []);
        }    
              

    }

    function signup($connect, $payload) {
                
        try {
            $password = password_hash($payload['password'], PASSWORD_DEFAULT);

            $emailCount = "";
            
            $checkEmailExist = $connect->prepare("SELECT COUNT(*) FROM seller WHERE email_address = ?");
            $checkEmailExist->bind_param("s", $payload['email_address']);
            $checkEmailExist->execute();
            $checkEmailExist->bind_result($emailCount);
            $checkEmailExist->fetch();
            $checkEmailExist->close();

            if ($emailCount > 0) {
                return array("title" => "Failed", "message" => "Email already exists!", "data" => []);
            }
            
            $stmt = $connect->prepare("INSERT INTO seller 
            (first_name, last_name, contact_number, address, email_address, password) 
            VALUES (?, ?, ?, ?, ?, ?)");
                        
            $stmt->bind_param("ssssss", $payload['first_name'], $payload['last_name'], $payload['contact_number'], 
                $payload['address'], $payload['email_address'], $password);
                    
            $stmt->execute();            
            if ($stmt->affected_rows <= 0) {
                return array("title" => "Failed", "message" => "Something went wrong!", "data" => []);
            }
            
            return array("title" => "Success", "message" => "Signup Successful", "data" => []);
            
        } catch (\Throwable $th) {             
            return array("title" => "Failed", "message" => "Something went wrong!", "data" => []);
        }        
    }

    function getData($connect, $sellerId) {
        try {

            $getData = $connect->prepare("SELECT 
                CONCAT(seller.first_name, ' ', seller.last_name) AS seller_name,
                seller.contact_number,
                seller.address,
                seller.email_address
            FROM seller
            WHERE seller_id = ?");
            $getData->bind_param("s", $sellerId);
            $getData->execute();

            $userData = $getData->get_result();
            $user = $userData->fetch_all(MYSQLI_ASSOC);

            return array(
                "title" => "Success", 
                "message" => "Information retrieved!", 
                "data" => $user);
        } catch (\Throwable $th) {
            return array(
                "title" => "Failed", 
                "message" => "Something went wrong! " . $th->getMessage() . " Please try again later",
                "data" => []
            );
        }
    }


?>
