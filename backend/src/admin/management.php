<?php

    function updateSellerStatus($connect, $payload) {
        try {

            $updateStatus = $connect->prepare("UPDATE seller SET status = ? WHERE seller_id = ?");
            $updateStatus->bind_param("ss", $payload["status"], $payload["seller_id"]);
            $updateStatus->execute();

            if ($updateStatus->affected_rows < 0) {
                throw new Exception("Cannot change the status");
            }
                       
            return array("title" => "Success", "message" => "Status updated successfully", "data" => []);
            
        } catch (\Throwable $th) {
            
            return array("title" => "Failed", "message" => "Something went wrong!" . $th->getMessage() , "data" => []);
        }        
    }

    function updateBuyerStatus($connect, $payload) {
        try {

            $updateStatus = $connect->prepare("UPDATE customer SET status = ? WHERE customer_id = ?");
            $updateStatus->bind_param("ss", $payload["status"], $payload["customer_id"]);
            $updateStatus->execute();

            if ($updateStatus->affected_rows < 0) {
                throw new Exception("Cannot change the status");
            }
                       
            return array("title" => "Success", "message" => "Status updated successfully", "data" => []);
            
        } catch (\Throwable $th) {
            
            return array("title" => "Failed", "message" => "Something went wrong!" . $th->getMessage() , "data" => []);
        }        
    }
?>