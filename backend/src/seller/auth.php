<?php

    
    function login($connect, $contactnumber, $password) {
        try {
            $stmt = $connect->prepare("SELECT * from seller WHERE contact_number = ?");
            $stmt->bind_param("s", $contactnumber);
            $stmt->execute();
            
            $userExist = $stmt->get_result();

            if ($userExist->num_rows <= 0 ) {
                return array("title" => "Failed", "message" => "Incorrect contact number and password", "data" => []);
            }
            
            $row = $userExist->fetch_assoc();
            
            if ($row['status'] === "Pending")  {                
                return array("title" => "Failed", "message" => "Your account is not yet verified. Please come back later.", "data" => []);
            } else if($row['status'] === "Not Verified"){
                return array("title" => "Failed", "message" => "Unfortunately, your account was not accepted", "data" => []);
            }

            if (!password_verify($password, $row['password'])) {                
                return array("title" => "Failed", "message" => "Incorrect Password. Please try again", "data" => []);
            }

            $_SESSION['seller_id'] = $row['seller_id'];
            $_SESSION["seller_name"] = $row['first_name'] . " " . $row['last_name'];
            $_SESSION["user_type"] = "seller";
            return array(
                "title" => "Success", 
                "message" => "Login Successful", 
                "data" => [
                    "seller_id" => $row['seller_id']
                ]
            );
        } catch (\Throwable $th) {
            
            return array("title" => "Failed", "message" => "Something went wrong!", "data" => []);
        }    
              

    }

    function signup($connect, $payload, $frontIdUrl, $backIdUrl, $proofUrl) {
                
        try {
            $password = password_hash($payload['password'], PASSWORD_DEFAULT);

            $contactCount = "";
            
            $checkEmailExist = $connect->prepare("SELECT COUNT(*) FROM seller WHERE contact_number = ?");
            $checkEmailExist->bind_param("s", $payload['contact_number']);
            $checkEmailExist->execute();
            $checkEmailExist->bind_result($contactCount);
            $checkEmailExist->fetch();
            $checkEmailExist->close();

            if ($contactCount > 0) {
                return array("title" => "Failed", "message" => "Contact Number exists!", "data" => []);
            }
            
            $stmt = $connect->prepare("INSERT INTO seller 
            (first_name, last_name, contact_number, address, email_address, password, front_id_url,
            back_id_url, proof_seller_url) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        
            $stmt->bind_param("sssssssss", $payload['first_name'], $payload['last_name'], $payload['contact_number'], 
                $payload['address'], $payload['email_address'], $password, $frontIdUrl, $backIdUrl, $proofUrl);                    
            $stmt->execute();            
            if ($stmt->affected_rows <= 0) {
                return array("title" => "Failed", "message" => "Something went wrong!", "data" => []);
            }
            
            return array("title" => "Success", "message" => "Signup Successful", "data" => []);
            
        } catch (\Throwable $th) {             
            return array("title" => "Failed", "message" => "Something went wrong! " .  $th, "data" => []);
        }        
    }

    function updateProfile($connect, $payload, $avatarUrl) {
        try {

            $fullname = $payload["fullname"];
            $names = explode(" ", $fullname, 2);        
            $first_name = $names[0]; 
            $last_name = $names[1]; 

            $stmt = $connect->prepare("UPDATE customer SET
                first_name = ?, last_name = ?, contact_number = ?, address = ?, 
                email_address = ?, avatar = ? WHERE customer_id = ?");
            $stmt->bind_param("sssssss", $first_name, $last_name, 
                $payload['phone'], $payload['address'], 
                $payload['email'], $avatarUrl, $payload["user_id"]);
            
                $stmt->execute();            
            if ($stmt->affected_rows <= 0) {
                return array("title" => "Failed", "message" => "Something went wrong!", "data" => []);
            }
            
            return array("title" => "Success", "message" => "Signup Successful", "data" => []);
            
        } catch (\Throwable $th) {
            
            return array("title" => "Success", "message" => "Something went wrong!", "data" => []);
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
