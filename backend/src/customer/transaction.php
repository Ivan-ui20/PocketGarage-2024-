<?php

    function generateOrderRefNo($customer_id) {
        
        $timestamp = time();

        $randomString = substr(md5(uniqid(mt_rand(), true)), 0, 6);
        
        $orderRefNo = 'REF-' . $customer_id . '-' . $timestamp . '-' . strtoupper($randomString);

        return $orderRefNo;
    }

    function sendOrder($connect, $payload, $items) {
        try {
            $connect->begin_transaction();
            
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
            
            $insertItems = $connect->prepare("INSERT INTO order_items 
                (order_id, model_id, quantity, total) VALUES (?, ?, ?, ?)");
        
            foreach ($items as $item) {
                $insertItems->bind_param("ssss", $orderId, $item["model_id"], 
                    $item["quantity"], $item["total"]);
                $insertItems->execute();
    
                if ($insertItems->affected_rows <= 0) {
                    throw new Exception("We cannot process your order.");
                }
            }
            
            $insertTracker = $connect->prepare("INSERT INTO order_tracker (order_id, current_track) VALUES (?, ?)");
            $initialTrack = "Order Placed"; 
            $insertTracker->bind_param("ss", $orderId, $initialTrack);
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



?>