<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/database/db.php';    
    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/src/shared/middleware/verify.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/src/shared/response.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/src/shared/file.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/src/chat/chat.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
        
        try {
            $route = $_GET['route'] ?? null;
            if ($route === 'chat/send') {
                $requiredFields = ['room_id', 'sender_id', 'message', 'user_type'];
                if (!array_diff_key(array_flip($requiredFields), $_POST)) {
                    
                    $payload = array_intersect_key($_POST, array_flip($requiredFields));
                    
                    $imageUrl = null;
                    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
                        $imageUrl = handleFileUpload($_FILES['attachment']);
                        if ($imageUrl === false) {
                            jsonResponse("File Upload Failed", "There was an error uploading the image. Please try again.");
                            return;
                        }
                    }                  

                    $response = sendMessage($conn, $payload, $imageUrl);

                    jsonResponse($response["title"], $response["message"]);

                } else {
                    jsonResponse("Invalid request", "Something went wrong!");
                }
            
            }
        } catch (\Throwable $th) {            
            return array("title" => "Error", "message" => "Something went wrong!", "data" => []);
        }

    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' ) {
        
        try {
            $route = $_GET['route'] ?? null;            
            if ($route === 'chat/get' && $_GET["room_id"] !== null) {
                $payload = [
                    "room_id" => $_GET['room_id'],
                    "limit" => $_GET['limit'],
                    "offset" => $_GET['offset'],
                ];
                $response = getMessages($conn, $payload);
                                
                jsonResponseWithData(
                    $response["title"], 
                    $response["message"], 
                    $response["data"]
                );                         
            } else {
                jsonResponse("Invalid request", "Something went wrong!");
            }
        } catch (\Throwable $th) {            
            return array("title" => "Error", "message" => "Something went wrong!", "data" => []);
        }

    }
?>