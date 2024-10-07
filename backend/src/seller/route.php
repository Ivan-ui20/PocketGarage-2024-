<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/database/db.php';    
    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/src/shared/middleware/verify.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/src/shared/response.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/src/shared/file.php';

    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/src/seller/auth.php';    
    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/src/seller/transaction.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/src/seller/diecast.php';
    
        
    if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
        
        try {
            
            $route = $_GET['route'] ?? null;
            if ($route === 'seller/login') {

                if (isset($_POST['email_address']) && isset($_POST['password'])) {
                    $email = $_POST['email_address'];
                    $password = $_POST['password'];

                    $response = login($conn, $email, $password);

                    jsonResponse($response["title"], $response["message"]);

                } else {
                    jsonResponse("Invalid Login", "Email and password are required.");
                }
            }

            if ($route === 'seller/signup') {
                $requiredFields = ['first_name', 'last_name', 'contact_number', 'address', 
                    'email_address', 'password'];

                if (!array_diff_key(array_flip($requiredFields), $_POST)) {
                    
                    $payload = array_intersect_key($_POST, array_flip($requiredFields));
                    
                    $response = signup($conn, $payload);

                    jsonResponse($response["title"], $response["message"]);

                } else {
                    jsonResponse("Invalid Signup", "All fields are required.");
                }
            }

            if ($route === 'seller/update/status/order') {
                $requiredFields = ['order_id', 'order_ref_no', 'order_status'];
                if (!array_diff_key(array_flip($requiredFields), $_POST)) {
                    
                    $payload = array_intersect_key($_POST, array_flip($requiredFields));
                    
                    $response = changeOrderStatus($conn, $payload);

                    jsonResponse($response["title"], $response["message"]);

                } else {
                    jsonResponse("Invalid request", "All fields are required.");
                }
            }

            if ($route === 'seller/add/product') {
                $requiredFields = ['seller_id', 'size_id', 'brand_id', 'model_name', 
                'model_description', 'model_price', 'model_stock', 'model_availability', 
                'model_tags', 'model_type'];

                if (!array_diff_key(array_flip($requiredFields), $_POST)) {
                    
                    $payload = array_intersect_key($_POST, array_flip($requiredFields));

                    $imageUrl = handleFileUpload($_FILES['model_image']);
                    if ($imageUrl === false) {
                        jsonResponse("File Upload Failed", "There was an error uploading the image. Please try again.");
                        return; // Exit early if upload fails
                    }
                    
                    $response = addDiecastProduct($conn, $payload, $imageUrl);

                    jsonResponse($response["title"], $response["message"]);

                } else {
                    jsonResponse("Invalid request", "All fields are required.");
                }
            }            

        } catch (\Throwable $th) {            
            return array("title" => "Error", "message" => "Something went wrong!", "data" => []);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' ) {
        
        try {
            $route = $_GET['route'] ?? null;
            if ($route === 'seller/get/products') {
                $requiredFields = ['seller_id'];

                if (!array_diff_key(array_flip($requiredFields), $_GET)) {
                    
                    $sellerId = $_GET['seller_id'];

                    $response = getDiecastProduct($conn, $sellerId);

                    jsonResponseWithData(
                        $response["title"], 
                        $response["message"], 
                        $response["data"]
                    );
            
                } else {
                    jsonResponse("Invalid cart item", "All fields are required.");
                }
            }
        } catch (\Throwable $th) {            
            return array("title" => "Error", "message" => "Something went wrong!", "data" => []);
        }
    }


?>