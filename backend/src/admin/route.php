<?php

    require_once '../../database/db.php';    
    require_once '../shared/middleware/verify.php';
    require_once '../shared/response.php';
    require_once '../shared/file.php';

    require_once './auth.php';
    require_once './management.php';
    
        
    if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
        
        try {
            
            $route = $_GET['route'] ?? null;
            if ($route === 'admin/login') {

                if (isset($_POST['contact_number']) && isset($_POST['password'])) {
                    $contactnumber = $_POST['contact_number'];
                    $password = $_POST['password'];

                    $response = login($conn, $contactnumber, $password);

                    jsonResponseWithData($response["title"], $response["message"], $response["data"]);

                } else {
                    jsonResponse("Invalid Login", "Email and password are required.");
                }
            }

            if ($route === 'admin/profile') {

                $requiredFields = ['user_id', 'fullname', 'email', 'phone', 
                'address'];
            
                $isImageEdited = $_POST["image_edited"];
                if (!array_diff_key(array_flip($requiredFields), $_POST)) {
                    
                    $payload = array_intersect_key($_POST, array_flip($requiredFields));
                    
                    $imageUrl = null;
                    if ($isImageEdited !== "false") {                        
                        $imageUrl = handleFileUpload($_FILES['avatar']);
                        if ($imageUrl === false) {
                            jsonResponse("File Upload Failed", "There was an error uploading the image. Please try again.");
                            return;
                        }
                    }

                    $response = updateProfile($conn, $payload, $imageUrl);

                    jsonResponse($response["title"], $response["message"]);

                } else {
                    jsonResponse("Invalid request", "All fields are required.");
                }
            } 

            if ($route === 'admin/seller/status') {
                $requiredFields = ['seller_id', 'status'];
                                
                if (!array_diff_key(array_flip($requiredFields), $_POST)) {
                                
                    $payload = $_POST;
                                            
                    $response = updateSellerStatus($conn, $payload);
            
                    jsonResponse($response["title"], $response["message"]);
            
                } else {
                    jsonResponse("Invalid order", "All fields are required.");
                }
            }

            if ($route === 'admin/buyer/status') {
                $requiredFields = ['customer_id', 'status'];
                                
                if (!array_diff_key(array_flip($requiredFields), $_POST)) {
                                
                    $payload = $_POST;
                                            
                    $response = updateBuyerStatus($conn, $payload);
            
                    jsonResponse($response["title"], $response["message"]);
            
                } else {
                    jsonResponse("Invalid order", "All fields are required.");
                }
            }



        
        } catch (\Throwable $th) {            
            return array("title" => "Error", "message" => "Something went wrong!", "data" => []);
        }

    }



?>