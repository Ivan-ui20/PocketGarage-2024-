<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/database/db.php';    
    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/src/shared/middleware/verify.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/src/shared/response.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/src/shared/file.php';

    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/src/seller/auth.php';    
    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/src/seller/transaction.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/src/seller/diecast.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/src/seller/bidding.php';
    
        
    if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
        
        try {
            
            $route = $_GET['route'] ?? null;
            if ($route === 'seller/login') {

                if (isset($_POST['contact_number']) && isset($_POST['password'])) {
                    $contactnumber = $_POST['contact_number'];
                    $password = $_POST['password'];

                    $response = login($conn, $contactnumber, $password);

                    jsonResponseWithData($response["title"], $response["message"], $response["data"]);

                } else {
                    jsonResponse("Invalid Login", "Email and password are required.");
                }
            }

            if ($route === 'seller/signup') {
                $requiredFields = ["customer_id"];

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

                    $proofUrl = handleFileUpload($_FILES['proof']);
                    if ($proofUrl === false) {
                        jsonResponse("File Upload Failed", "There was an error uploading the image. Please try again.");
                        return;
                    }
                    $response = signup($conn, $payload, $frontIdUrl, $backIdUrl, $proofUrl);

                    jsonResponse($response["title"], $response["message"]);

                } else {
                    jsonResponse("Invalid Signup", "All fields are required.");
                }
            }

            if ($route === 'seller/update/status/order') {
                $requiredFields = ['order_id', 'order_ref_no', 'order_status', "order_trackingnum"];
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
                'model_tags', 'model_type', "model_packaging", "model_condition"];

                if (!array_diff_key(array_flip($requiredFields), $_POST)) {
                    
                    $payload = array_intersect_key($_POST, array_flip($requiredFields));

                    $imageUrl = handleFileUpload($_FILES['model_image']);
                    if ($imageUrl === false) {
                        jsonResponse("File Upload Failed", "There was an error uploading the image. Please try again.");
                        return;
                    }
                    
                    $response = addDiecastProduct($conn, $payload, $imageUrl);

                    jsonResponse($response["title"], $response["message"]);

                } else {
                    jsonResponse("Invalid request", "All fields are required.");
                }
            }
            
            if ($route === 'seller/edit/product') {
                $requiredFields = ['model_id', 'seller_id', 'model_name', 
                'model_description', 'model_price', 'model_availability', ];

                // $isImageEdited = $_POST["image_edited"];

                if (!array_diff_key(array_flip($requiredFields), $_POST)) {
                    
                    $payload = array_intersect_key($_POST, array_flip($requiredFields));

                    // $imageUrl = $payload['model_image_url'];
                    // if ($isImageEdited) {
                    //     $imageUrl = handleFileUpload($_FILES['model_image']);
                    //     if ($imageUrl === false) {
                    //         jsonResponse("File Upload Failed", "There was an error uploading the image. Please try again.");
                    //         return;
                    //     }
                    // }

                    $response = editDiecastProduct($conn, $payload);

                    jsonResponse($response["title"], $response["message"]);

                } else {
                    jsonResponse("Invalid request", "All fields are required.");
                    }
                } 

            if ($route === 'seller/delete/product') {
                $requiredFields = ['model_id', 'seller_id'];
                
                if (!array_diff_key(array_flip($requiredFields), $_POST)) {
                    
                    $payload = array_intersect_key($_POST, array_flip($requiredFields));

                    $response = deleteDiecastProduct($conn, $payload['model_id'], $payload['seller_id']);
                    
                    jsonResponse($response["title"], $response["message"]);

                } else {
                    jsonResponse("Invalid request", "All fields are required.");
                }
            } 

            if ($route === 'seller/post/bid') {
                $requiredFields = ['seller_id', 'size_id', 'brand_id', 'model_name', 
                'model_description', 'model_price', 'model_stock', 'model_availability', 
                'model_tags', 'model_type', "model_packaging", "model_condition",
                'details', 'start_amount', 'start_time', 'end_time', 'appraisal_value'];
      

                if (!array_diff_key(array_flip($requiredFields), $_POST)) {
                    
                    $payload = array_intersect_key($_POST, array_flip($requiredFields));

                    $imageUrl = handleFileUpload($_FILES['model_image']);
                    if ($imageUrl === false) {
                        jsonResponse("File Upload Failed", "There was an error uploading the image. Please try again.");
                        return;
                    }
                    
                    $response = postBidItem($conn, $payload, $imageUrl);

                    jsonResponse($response["title"], $response["message"]);

                } else {
                    jsonResponse("Invalid request", "All fields are required.");
                }
            }

            if ($route === 'seller/close/bid') {
                $requiredFields = ['bidding_id'];
                if (!array_diff_key(array_flip($requiredFields), $_POST)) {
                    
                    $payload = array_intersect_key($_POST, array_flip($requiredFields));
                    
                    $response = closeBidItem($conn, $payload);

                    jsonResponse($response["title"], $response["message"]);

                } else {
                    jsonResponse("Invalid request", "All fields are required.");
                }
            }

            if ($route === 'seller/cancel/bid') {
                $requiredFields = ['bidding_id'];
                if (!array_diff_key(array_flip($requiredFields), $_POST)) {
                                                            
                    $response = cancelBidItem($conn, $_POST["bidding_id"]);

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
                    $brand = isset($_GET['brand']) ? $_GET['brand'] : null;
                    $scale = isset($_GET['scale']) ? $_GET['scale'] : null;
                    $minPrice = isset($_GET['min_price']) ? $_GET['min_price'] : null;
                    $maxPrice = isset($_GET['max_price']) ? $_GET['max_price'] : null;
                    $modelStock = isset($_GET['model_stock']) ? $_GET['model_stock'] : null;
                    $modelAvailability = isset($_GET['model_availability']) ? $_GET['model_availability'] : null;
                    $modelTags = isset($_GET['model_tags']) ? $_GET['model_tags'] : null;
                    $modelType = isset($_GET['model_type']) ? $_GET['model_type'] : null;
                    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;
                    $modelName = isset($_GET['model_name']) ? $_GET['model_name'] : null;

                    $response = getDiecastProduct($conn, $sellerId, $brand, $scale, $minPrice, $maxPrice, $modelStock, 
                    $modelAvailability, $modelTags, $modelType, $limit, $offset, $modelName);
                    
                    jsonResponseWithData(
                        $response["title"], 
                        $response["message"], 
                        $response["data"]
                    );
            
                } else {
                    jsonResponse("Invalid cart item", "All fields are required.");
                }
            }

            if ($route === 'seller/get/bid/post') {
                $requiredFields = ['seller_id'];

                if (!array_diff_key(array_flip($requiredFields), $_GET)) {
                    
                    $sellerId = $_GET['seller_id'];
                    
                    $response = getBidItem($conn, $sellerId);
                    
                    jsonResponseWithData(
                        $response["title"], 
                        $response["message"], 
                        $response["data"]
                    );
            
                } else {
                    jsonResponse("Invalid cart item", "All fields are required.");
                }
            }

            if ($route === 'account/view') {
                $sellerId = $_GET['seller_id'];

                $response = getData($conn, $sellerId);

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