<?php

    function reduceStock($connect, $order_id) {             
        try {
           
            $getOrderQuantityPerModel = $connect->prepare("SELECT quantity, model_id 
                FROM order_items WHERE order_id = ?");            
            $getOrderQuantityPerModel->bind_param("s", $order_id);
            
            $getOrderQuantityPerModel->execute();
        
            $order = $getOrderQuantityPerModel->get_result();
            $orders = $order->fetch_all(MYSQLI_ASSOC);
            $getOrderQuantityPerModel->close();
            
            if (count($orders) <= 0) {             
                return false;
            }

            foreach ($orders as $orderItem) {
                
                $quantity = $orderItem['quantity'];
                $model_id = $orderItem['model_id'];
                $currentStock = 0;

                $getCurrentStock = $connect->prepare("SELECT model_stock FROM diecast_model WHERE model_id = ?");
                
                $getCurrentStock->bind_param("s", $model_id);
                $getCurrentStock->execute();
                $getCurrentStock->bind_result($currentStock);
                $getCurrentStock->fetch();
                $getCurrentStock->close();

                if ($currentStock >= $quantity) {
                    
                    $newStock = $currentStock - $quantity;                    
                    $updateStock = $connect->prepare("UPDATE diecast_model SET model_stock = ? WHERE model_id = ?");                    
                    $updateStock->bind_param("is", $newStock, $model_id);
                            
                    $updateStock->execute();
                    if ($updateStock->affected_rows <= 0) {
                        throw new Exception("Something went wrong");  
                    }
                } else {                    
                    return false; 
                }
            }
    
            return true;

        } catch (\Throwable $th) {
            
            return false;
        }
    }

    function changeOrderStatus($connect, $payload) {

        $connect->begin_transaction();
                
        try  {

            if ($payload["order_status"] === "Order Placed" && !reduceStock($connect, $payload['order_id'])) {                
                throw new Exception("There is item that is out of stock!");  
            }

            $orderStatus = $connect->prepare("UPDATE order_info SET order_status = ? WHERE order_id = ?");
            $orderStatus->bind_param("ss", $payload['order_status'], $payload['order_id']);
            $orderStatus->execute();
            
            if ($orderStatus->affected_rows <= 0) {
                throw new Exception("Order Reference Number " . $payload['order_ref_no'] . " was not found.");  
            }

            $orderTracker = $connect->prepare("INSERT INTO order_tracker(order_id, current_track) VALUES (?, ?)");
            $orderTracker->bind_param("ss", $payload['order_id'], $payload['order_status']);
            $orderTracker->execute();
            
            if ($orderTracker->affected_rows <= 0) {
                throw new Exception("Order Reference Number " . $payload['order_ref_no'] . " was not found.");  
            }

            $connect->commit(); 
            return array(
                "title" => "Success", 
                "message" => "Order successfully changed to '" . $payload['order_status'] ."'", 
                "data" => []
            );


        } catch (\Throwable $th) {
            $connect->rollback();
            return array(
                "title" => "Failed", 
                "message" => "Something went wrong! " . $th->getMessage() . " Please try again later",
                "data" => []);
        }   
    }

    function getOrders($connect, $sellerId) {
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
                        ', customer_name: ', CONCAT(customer.first_name, ' ', customer.last_name),
                        ', contact_number: ', customer.contact_number, '}'
                    ) SEPARATOR ', '
                ) AS diecast_model_info

            FROM order_info 
            LEFT JOIN order_items ON order_items.order_id = order_info.order_id
            LEFT JOIN order_tracker ON order_tracker.order_id = order_info.order_id
            LEFT JOIN diecast_model ON diecast_model.model_id = order_items.model_id
            LEFT JOIN diecast_size ON diecast_size.size_id = diecast_model.size_id
            LEFT JOIN diecast_brand ON diecast_brand.brand_id = diecast_model.brand_id
            LEFT JOIN customer ON customer.customer_id = order_info.customer_id
            WHERE diecast_model.seller_id = ?
            GROUP BY order_info.order_id
            ORDER BY order_info.created_at DESC;");
            $getOrder->bind_param("s", $sellerId);
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