<?php

    require_once '../../database/db.php';    
    require_once '../shared/middleware/verify.php';
    require_once '../shared/response.php';
    require_once '../shared/file.php';

    require_once './auth.php';
    require_once './transaction.php';
    require_once './cart.php';
    require_once './diecast.php';
    
        
    if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
        
        try {
            
            $route = $_GET['route'] ?? null;
            if ($route === 'customer/login') {

                if (isset($_POST['contact_number']) && isset($_POST['password'])) {
                    $contactnumber = $_POST['contact_number'];
                    $password = $_POST['password'];

                    $response = login($conn, $contactnumber, $password);

                    jsonResponseWithData($response["title"], $response["message"], $response["data"]);

                } else {
                    jsonResponse("Invalid Login", "Email and password are required.");
                }
            }

            if ($route === 'customer/signup') {
                $requiredFields = ['first_name', 'last_name', 'contact_number', 'address', 'email_address', 'password'];
                if (!array_diff_key(array_flip($requiredFields), $_POST)) {
                    
                    $payload = array_intersect_key($_POST, array_flip($requiredFields));
                    

                    $frontIdUrl = handleFileUpload($_FILES['id_front']);                              
                    if ($frontIdUrl === false) {
                        jsonResponse("File Upload Failed", "There was an error uploading the image. Please try again.");
                        return;
                    }
                    

                    $backIdUrl = handleFileUpload($_FILES['id_back']);                    
                    if ($backIdUrl === false) {
                        jsonResponse("File Upload Failed", "There was an error uploading the image. Please try again.");
                        return;
                    }
                    
                    
                    $response = signup($conn, $payload, $frontIdUrl, $backIdUrl);

                    jsonResponse($response["title"], $response["message"]);

                } else {
                    jsonResponse("Invalid Signup", "All fields are required.");
                }
            }

            if ($route === 'customer/send/order') {
                $requiredFields = ['customer_id', 'shipping_addr', 'order_total', 
                    'order_payment_option', 'items', 'cart_id'];
                                
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

            if ($route === 'customer/delete/item/cart') {
                $requiredFields = ['model_id', 'cart_id'];

                if (!array_diff_key(array_flip($requiredFields), $_POST)) {
                                
                    $modelId = $_POST['model_id'];
                    $cartId = $_POST['cart_id'];
                                        
                    if (!$modelId || !$cartId) {
                        jsonResponse("Invalid Request", "Something went wrong!");
                    }
                                
                    $response = deleteCartItem($conn, $modelId, $cartId);
            
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
                    jsonResponse("User not found", "Log in first.");
                }
            }

            if ($route === 'products') {
                                                           
                $brand = isset($_GET['brand']) ? $_GET['brand'] : null;
                $scale = isset($_GET['size']) ? $_GET['size'] : null;
                $minPrice = isset($_GET['min_price']) ? $_GET['min_price'] : null;
                $maxPrice = isset($_GET['max_price']) ? $_GET['max_price'] : null;
                $modelStock = isset($_GET['model_stock']) ? $_GET['model_stock'] : null;
                $modelAvailability = isset($_GET['model_availability']) ? $_GET['model_availability'] : null;
                $modelTags = isset($_GET['model_tags']) ? $_GET['model_tags'] : null;
                $modelType = isset($_GET['model_type']) ? $_GET['model_type'] : null;
                $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 100;
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $offset = ($page - 1) * $limit;
                $modelName = isset($_GET['model_name']) ? $_GET['model_name'] : null;

                $response = getDiecastProduct($conn, $brand, $scale, $minPrice, $maxPrice, $modelStock, 
                $modelAvailability, $modelTags, $modelType, $limit, $offset, $modelName);
                                            
                jsonResponseWithData(
                    $response["title"], 
                    $response["message"], 
                    $response["data"]
                );
            
            }

            if ($route === 'account/view') {
                $customerId = $_GET['customer_id'];

                $response = getData($conn, $customerId);

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