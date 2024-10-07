<?php


    function changeOrderStatus($connect, $payload) {

        try  {

            $stmt = $connect->prepare("UPDATE order_info SET order_status = ? WHERE order_id = ?");
            $stmt->bind_param("ss", $payload['order_status'], $payload['order_id']);
            $stmt->execute();
            
            if ($stmt->affected_rows <= 0) {
                return array(
                    "title" => "Order not found", 
                    "message" => "Order Reference Number " . $payload['order_ref_no'] . " was not found.", 
                    "data" => []
                );
            }

            return array(
                "title" => "Success", 
                "message" => "Order successfully changed to '" . $payload['order_status'] ."'", 
                "data" => []
            );


        } catch (\Throwable $th) {
            
            return array("title" => "Success", "message" => "Something went wrong!", "data" => []);
        }   
    }



?>