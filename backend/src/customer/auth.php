<?php

    function login($connect, $contactNumber, $password) {
        
        try {

            $stmt = $connect->prepare("SELECT * from customer WHERE contact_number = ?");
            $stmt->bind_param("s", $contactNumber);
            $stmt->execute();
            
            $userExist = $stmt->get_result();

            if ($userExist->num_rows <= 0 ) {
                return array("title" => "Failed", "message" => "Incorrect contact number and password", "data" => []);
            }

            $row = $userExist->fetch_assoc();

            if (!password_verify($password, $row['password'])) {                
                return array("title" => "Failed", "message" => "Incorrect Password. Please try again", "data" => []);
            }

            return array("title" => "Success", "message" => "Login Successful", "data" => []);
        } catch (\Throwable $th) {
            
            return array("title" => "Success", "message" => "Something went wrong!", "data" => []);
        }        
    }

    function signup($connect, $payload, $frontIdUrl, $backIdUrl) {        

        try {
            $password = password_hash($payload['password'], PASSWORD_DEFAULT);

            $email_count = "";
            
            $email_check_stmt = $connect->prepare("SELECT COUNT(*) FROM customer WHERE email_address = ?");
            $email_check_stmt->bind_param("s", $payload['email_address']);
            $email_check_stmt->execute();
            $email_check_stmt->bind_result($email_count);
            $email_check_stmt->fetch();
            $email_check_stmt->close();

            if ($email_count > 0) {
                return array("title" => "Failed", "message" => "Email already exists!", "data" => []);
            }

            $stmt = $connect->prepare("INSERT INTO customer 
                (first_name, last_name, contact_number, address, email_address, password, front_id_url, back_id_url) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $payload['first_name'], $payload['last_name'], 
                $payload['contact_number'], $payload['address'], 
                $payload['email_address'], $password, $frontIdUrl, $backIdUrl);
            
                $stmt->execute();            
            if ($stmt->affected_rows <= 0) {
                return array("title" => "Failed", "message" => "Something went wrong!", "data" => []);
            }
            
            return array("title" => "Success", "message" => "Signup Successful", "data" => []);
            
        } catch (\Throwable $th) {
            
            return array("title" => "Success", "message" => "Something went wrong!", "data" => []);
        }        
    }

    function getData($connect, $customerId) {
        try {

            $getData = $connect->prepare("SELECT 
                CONCAT(customer.first_name, ' ', customer.last_name) AS customer_name,
                customer.contact_number,
                customer.address,
                customer.email_address
            FROM customer
            WHERE customer_id = ?");
            $getData->bind_param("s", $customerId);
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
