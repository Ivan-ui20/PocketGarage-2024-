<?php

    function login($connect, $username, $password) {
        
        try {

            $stmt = $connect->prepare("SELECT * from admin WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            
            $userExist = $stmt->get_result();

            if ($userExist->num_rows <= 0 ) {
                return array("title" => "Failed", "message" => "Incorrect username and password", "data" => []);
            }

            $row = $userExist->fetch_assoc();

            if (!password_verify($password, $row['password'])) {                
                return array("title" => "Failed", "message" => "Incorrect Password. Please try again", "data" => []);
            }
            $_SESSION['admin_id'] = $row['admin_id'];
            return array(
                "title" => "Success", 
                "message" => "Login Successful", 
                "data" => [
                    "admin_id" => $row['admin_id']
                ]
            );
        } catch (\Throwable $th) {
            
            return array("title" => "Success", "message" => "Something went wrong!", "data" => []);
        }        
    }

    function updateProfile($connect, $payload, $avatarUrl) {
        try {

            $fullname = $payload["fullname"];
            $names = explode(" ", $fullname, 2);        
            $first_name = $names[0]; 
            $last_name = $names[1]; 

            if ($avatarUrl != null) {
                $stmt = $connect->prepare("UPDATE customer SET
                    first_name = ?, last_name = ?, contact_number = ?, address = ?, 
                    email_address = ?, avatar = ? WHERE customer_id = ?");
                $stmt->bind_param("sssssss", $first_name, $last_name, 
                    $payload['phone'], $payload['address'], 
                    $payload['email'], $avatarUrl, $payload["user_id"]);
            } else {
                $stmt = $connect->prepare("UPDATE customer SET
                    first_name = ?, last_name = ?, contact_number = ?, address = ?, 
                    email_address = ? WHERE customer_id = ?");
                $stmt->bind_param("ssssss", $first_name, $last_name, 
                    $payload['phone'], $payload['address'], 
                    $payload['email'], $payload["user_id"]);
            }
                        
            $stmt->execute();           
            if ($stmt->affected_rows <= 0) {
                return array("title" => "Failed", "message" => "Something went wrong!", "data" => []);
            }
            
            return array("title" => "Success", "message" => "Signup Successful", "data" => []);
            
        } catch (\Throwable $th) {
            
            return array("title" => "Success", "message" => "Something went wrong!", "data" => []);
        }        
    }    

?>
