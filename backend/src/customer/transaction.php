<?php

    function generateOrderRefNo($customer_id) {
        
        $timestamp = time();

        $randomString = substr(md5(uniqid(mt_rand(), true)), 0, 6);
        
        $orderRefNo = 'REF-' . $customer_id . '-' . $timestamp . '-' . strtoupper($randomString);

        return $orderRefNo;
    }

    function checkIfEnoughStocks($connect, $model_id, $quantity) {
        try {
            $model_stock = 0;
            $checkStock = $connect->prepare("SELECT model_stock FROM diecast_model WHERE model_id = ?");
            $checkStock->bind_param("s", $model_id);
                        
            $checkStock->execute();
                        
            $checkStock->store_result();
                        
            if ($checkStock->num_rows === 0) return false; 
                                                                    
            $checkStock->bind_result($model_stock);
            $checkStock->fetch(); 
                        
            return $model_stock >= $quantity; 
            
        } catch (\Throwable $th) {            
            // error_log("Error checking stock: " . $th->getMessage());
            return false; 
        }
    }
    
    function sendOrder($connect, $payload, $items) {

        $connect->begin_transaction();
        
        try {
            $refNo = generateOrderRefNo($payload["customer_id"]);
            
            $insertOrder = $connect->prepare("INSERT INTO order_info 
                (customer_id, shipping_addr, order_ref_no, order_total, order_payment_option) 
                VALUES (?, ?, ?, ?, ?)");
            $insertOrder->bind_param("sssss", $payload["customer_id"], $payload["shipping_addr"], 
                $refNo, $payload["order_total"], $payload["order_payment_option"]);
            $insertOrder->execute();
    
            if ($insertOrder->affected_rows <= 0) {
                throw new Exception("We cannot process your order.");
            }
            
            $orderId = $insertOrder->insert_id;
                               
            foreach ($items as $item) {
                $checkStock = checkIfEnoughStocks($connect, $item["id"], $item["quantity"]);
                if ($checkStock) {
                    $total = $item["quantity"] * $item["price"];
                    $insertItems = $connect->prepare("INSERT INTO order_items 
                    (order_id, model_id, quantity, total) VALUES (?, ?, ?, ?)");
                    $insertItems->bind_param("ssss", $orderId, $item["id"], 
                        $item["quantity"], $total);
                    $insertItems->execute();
        
                    if ($insertItems->affected_rows <= 0) {
                        throw new Exception("We cannot process your order.");
                    }
                    
                    $deleteItem = $connect->prepare("DELETE FROM cart_items 
                    WHERE cart_id = ? AND model_id = ?");
                    $deleteItem->bind_param("ss", $payload["cart_id"], $item["id"]);
                    $deleteItem->execute();
        
                    if ($deleteItem->affected_rows <= 0) {
                        throw new Exception("We cannot process your order.");
                    }
                } else {
                    throw new Exception("We cannot process your order");
                }                
            }
            
            $insertTracker = $connect->prepare("INSERT INTO order_tracker (order_id) VALUES (?)");            
            $insertTracker->bind_param("s", $orderId);
            $insertTracker->execute();
    
            if ($insertTracker->affected_rows <= 0) {
                throw new Exception("We cannot process your order.");
            }            
            $connect->commit();


    
            return array(
                "title" => "Success", 
                "message" => "Order was placed successfully.", 
                "data" => []
            );
    
        } catch (\Throwable $th) {
        
            $connect->rollback();
    
            return array(
                "title" => "Failed", 
                "message" => "Something went wrong! " . $th->getMessage() ." Please try again later",
                "data" => []
            );
        }
    }

    function getOrders($connect, $customerId) {
        try {

            $getOrder = $connect->prepare("SELECT 
                order_info.order_id,
                order_info.shipping_addr,
                order_info.order_ref_no,
                order_info.order_total,
                order_info.order_payment_option,
                order_info.order_status,
                order_info.created_at,
                
                GROUP_CONCAT(
                    CONCAT(
                        '{current_track: ', order_tracker.current_track, ', tracker_date: ', order_tracker.created_at, '}'
                    ) SEPARATOR ', '
                ) AS order_tracker_info,
                
                GROUP_CONCAT(
                    CONCAT(
                        '{model_name: ', diecast_model.model_name,
                        ', brand_name: ', diecast_brand.brand_name,
                        ', ratio: ', diecast_size.ratio,
                        ', model_description: ', diecast_model.model_description,
                        ', model_price: ', diecast_model.model_price,
                        ', model_stock: ', diecast_model.model_stock,
                        ', model_availability: ', diecast_model.model_availability,
                        ', model_tags: ', diecast_model.model_tags,
                        ', model_type: ', diecast_model.model_type,
                        ', model_image_url: ', diecast_model.model_image_url,
                        ', seller_name: ', CONCAT(seller.first_name, ' ', seller.last_name),
                        ', contact_number: ', seller.contact_number, '}'
                    ) SEPARATOR ', '
                ) AS diecast_model_info

            FROM order_info 
            LEFT JOIN order_items ON order_items.order_id = order_info.order_id
            LEFT JOIN order_tracker ON order_tracker.order_id = order_info.order_id
            LEFT JOIN diecast_model ON diecast_model.model_id = order_items.model_id
            LEFT JOIN diecast_size ON diecast_size.size_id = diecast_model.size_id
            LEFT JOIN diecast_brand ON diecast_brand.brand_id = diecast_model.brand_id
            LEFT JOIN seller ON seller.seller_id = diecast_model.seller_id
            WHERE order_info.customer_id = ?
            GROUP BY order_info.order_id
            ORDER BY order_info.created_at DESC;");
            $getOrder->bind_param("s", $customerId);
            $getOrder->execute();

            $orders = $getOrder->get_result();
            $userOrders = $orders->fetch_all(MYSQLI_ASSOC);

            if (count($userOrders) <= 0) {
                return array(
                    "title" => "Success", 
                    "message" => "You don't have any order yet. Go to shop and shop your first order now!", 
                    "data" => []);
            }
    
            return array(
                "title" => "Success", 
                "message" => "Your orders retrieved!", 
                "data" => $userOrders);

        } catch (\Throwable $th) {
            return array(
                "title" => "Failed", 
                "message" => "Something went wrong! " . $th->getMessage() . " Please try again later",
                "data" => []
            );
        }
    }

?>