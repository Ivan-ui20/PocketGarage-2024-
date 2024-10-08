<?php

    function checkIfItemIsInBidding($connect, $modelId) {

        try {

            $checkItem = $connect->prepare("SELECT COUNT(*) FROM bid_room WHERE model_id = ?");
            $checkItem->bind_param("s", $modelId);
            $checkItem->execute();

            $result = $checkItem->get_result();
            $checkItem->close();
            
            if ($result->num_rows > 0) {
                return true;
            }
            return false;

        } catch (\Throwable $th) {
            return true;
        }
    }

    function postBidItem($connect, $payload) {
        

        try {

            $postBidItem = $connect->prepare("INSERT INTO bid_room");

        } catch (\Throwable $th) {
            return array(
                "title" => "Failed", 
                "message" => "Something went wrong! " . $th->getMessage() . " 
                    Please try again later",
                "data" => []
            );
        }
        
    }
    function getBidItem($connect, $sellerId) {
        try {

        } catch (\Throwable $th) {
            return array(
                "title" => "Failed", 
                "message" => "Something went wrong! " . $th->getMessage() . " 
                    Please try again later",
                "data" => []
            );
        }
    }


?>