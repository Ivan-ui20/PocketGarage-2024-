<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/database/db.php';    
    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/src/shared/middleware/verify.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/src/shared/response.php';

    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/src/customer/auth.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/src/customer/transaction.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/src/customer/cart.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/src/customer/diecast.php';
    

    
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
        
        try {
            
            $route = $_GET['route'] ?? null;
            if ($route === 'customer/login') {

                if (isset($_POST['email_address']) && isset($_POST['password'])) {
                    $email = $_POST['email_address'];
                    $password = $_POST['password'];

                    $response = login($conn, $email, $password);

                    jsonResponse($response["title"], $response["message"]);

                } else {
                    jsonResponse("Invalid Login", "Email and password are required.");
                }
            }

            if ($route === 'customer/signup') {
                $requiredFields = ['first_name', 'last_name', 'contact_number', 'address', 'email_address', 'password'];
                if (!array_diff_key(array_flip($requiredFields), $_POST)) {
                    
                    $payload = array_intersect_key($_POST, array_flip($requiredFields));
                    
                    $response = signup($conn, $payload);

                    jsonResponse($response["title"], $response["message"]);

                } else {
                    jsonResponse("Invalid Signup", "All fields are required.");
                }
            }

            if ($route === 'customer/send/order') {
                $requiredFields = ['customer_id', 'shipping_addr', 'order_total', 
                    'order_payment_option', 'items'];
                                
                if (!array_diff_key(array_flip($requiredFields), $_POST)) {
                                
                    $payload = $_POST;
                    $items = json_decode($payload['items'], true);
                    
                    if (!is_array($items) || count($items) === 0) {
                        jsonResponse("Invalid order", "At least one item is required.");
                    }
                                
                    $response = sendOrder($conn, $payload, $items);
            
                    jsonResponse($response["title"], $response["message"]);
            
                } else {
                    jsonResponse("Invalid order", "All fields are required.");
                }
            }

            if ($route === 'customer/save/cart') {
                $requiredFields = ['customer_id', 'items'];
                                
                if (!array_diff_key(array_flip($requiredFields), $_POST)) {
                                
                    $payload = $_POST;
                    $items = json_decode($payload['items'], true);
                    
                    if (!is_array($items) || count($items) === 0) {
                        jsonResponse("Empty Cart", "At least one item is required.");
                    }
                                
                    $response = insertCartItem($conn, $payload, $items);
            
                    jsonResponse($response["title"], $response["message"]);
            
                } else {
                    jsonResponse("Invalid cart item", "All fields are required.");
                }
            }
        
        } catch (\Throwable $th) {            
            return array("title" => "Error", "message" => "Something went wrong!", "data" => []);
        }

    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' ) {

        try {
            $route = $_GET['route'] ?? null;
            if ($route === 'customer/get/cart') {
                $requiredFields = ['customer_id'];
                          
                if (!array_diff_key(array_flip($requiredFields), $_GET)) {
                    
                    $customerId = $_GET['customer_id'];
                                                                                            
                    $response = getCartItem($conn, $customerId);
                                
                    jsonResponseWithData(
                        $response["title"], 
                        $response["message"], 
                        $response["data"]
                    );
            
                } else {
                    jsonResponse("Invalid cart item", "All fields are required.");
                }
            }

            if ($route === 'products') {
                                                                                                                                                                                              
                $response = getDiecastProduct($conn);
                            
                jsonResponseWithData(
                    $response["title"], 
                    $response["message"], 
                    $response["data"]
                );
            
            }
            
        } catch (\Throwable $th) {            
            return array("title" => "Error", "message" => "Something went wrong!", "data" => []);
        }

    }





?>