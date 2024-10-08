<?php

    function encryptMessage($message) {
        $env = parse_ini_file($_SERVER['DOCUMENT_ROOT'] .'/backend/.env');

        $key = $env['KEY'];
        
        $cipher = "AES-256-CBC";
        $ivlen = openssl_cipher_iv_length($cipher);
        
        $iv = openssl_random_pseudo_bytes($ivlen);
            
        $ciphertext = openssl_encrypt($message, $cipher, $key, 0, $iv);
            
        return base64_encode($ciphertext . '::' . $iv);
    }

    function decryptMessage($message) {

        $env = parse_ini_file($_SERVER['DOCUMENT_ROOT'] .'/backend/.env');

        $key = $env['KEY'];

        list($ciphertext_data, $iv) = explode('::', base64_decode($message), 2);
        
        return openssl_decrypt($ciphertext_data, "AES-256-CBC", $key, 0, $iv);
    }


    function createChatRoom($connect, $payload) {

        try {

            $checkExistingRoom = $connect->prepare("SELECT COUNT(*) FROM chat_room WHERE seller_id = ? AND customer_id = ?");
            $checkExistingRoom->bind_param("ss", $payload["seller_id"], $payload["customer_id"]);
            $checkExistingRoom->execute();
        
            $result = $checkExistingRoom->get_result();
            $checkExistingRoom->close();
            
            if ($result->num_rows > 0) {
                return array(
                    "title" => "Success", 
                    "message" => "Chat room already exist", 
                    "data" => []
                );
            } 

            $createChatRoom = $connect->prepare("INSERT INTO chat_room(seller_id, customer_id) VALUES (?, ?)");
            $createChatRoom->bind_param("ss", $payload["seller_id"], $payload["customer_id"]);
            $createChatRoom->execute();


            if ($createChatRoom->affected_rows < 0) {
                throw new Exception("We cannot create a new chat room.");
            }

            return array(
                "title" => "Success", 
                "message" => "Chat room created.",
                "data" => []
            );

        } catch (\Throwable $th) {
            return array(
                "title" => "Failed", 
                "message" => "Something went wrong! " . $th->getMessage() . " Please try again later",
                "data" => []
            );
        }
    }
    
    function sendMessage($connect, $payload, $imageUrl) {
        try {

            $encryptMessage = encryptMessage($payload["message"]);

            $sendMessage = $connect->prepare("INSERT INTO chat_message(room_id, sender_id, user_type, encrypted_message, attachment) VALUES (?, ?, ?, ?, ?)");
            $sendMessage->bind_param("sssss", $payload["room_id"], $payload["sender_id"], $payload["user_type"], $encryptMessage, $imageUrl);
            $sendMessage->execute();

            if ($sendMessage->affected_rows < 0) {
                throw new Exception("We cannot send your message.");
            }

            return array(
                "title" => "Success", 
                "message" => "Message sent.",
                "data" => []
            );

        } catch (\Throwable $th) {
            return array(
                "title" => "Failed", 
                "message" => "Something went wrong! " . $th->getMessage() . " Please try again later",
                "data" => []
            );
        }
    } 

    function getMessages($connect, $payload) {
        try {

            $limit = $payload['limit'] ?? 10;
            $offset = $payload['offset'] ?? 0; 
                        
            $getMessages = $connect->prepare("SELECT 
                chat_message.message_id,
                chat_message.encrypted_message AS message,
                chat_message.attachment,
                chat_message.sent_at,
                CONCAT(customer.first_name, ' ', customer.last_name) AS customer_name,
                CONCAT(seller.first_name, ' ', seller.last_name) AS seller_name,                
                CASE
                    WHEN chat_message.sender_id = chat_room.customer_id THEN 'customer'
                    WHEN chat_message.sender_id = chat_room.seller_id THEN 'seller'
                END AS sender_type
                
            FROM 
                chat_message
                        
            INNER JOIN chat_room ON chat_message.room_id = chat_room.room_id
                        
            LEFT JOIN customer ON chat_room.customer_id = customer.customer_id
            LEFT JOIN seller ON chat_room.seller_id = seller.seller_id            
            WHERE 
                chat_message.room_id = ? 
                AND chat_message.sent_at >= NOW() - INTERVAL 1 DAY            
            ORDER BY chat_message.sent_at ASC
            LIMIT ? OFFSET ?");

        
            $getMessages->bind_param("iii", $payload["room_id"], $limit, $offset);
            $getMessages->execute();
            $result = $getMessages->get_result();
                
            $messages = [];
            while ($row = $result->fetch_assoc()) {                
                $decrypted_message = decryptMessage($row['message']);
                                
                $messages[] = [
                    'message_id' => $row['message_id'],
                    'message' => $decrypted_message, 
                    'attachment' => $row['attachment'],
                    'sent_at' => $row['sent_at'],
                    'customer_name' => $row['customer_name'],
                    'seller_name' => $row['seller_name']
                ];
            }
            
    
            return array(
                "title" => "Success", 
                "message" => "Messages fetched successfully",
                "data" => $messages
            );
            

        } catch (\Throwable $th) {
            return array(
                "title" => "Failed", 
                "message" => "Something went wrong! " . $th->getMessage() . " Please try again later",
                "data" => []
            );
        }
    }


?>
