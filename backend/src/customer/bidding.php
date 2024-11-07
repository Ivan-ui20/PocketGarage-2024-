<?php

function placeBid($connect, $payload) {

    $connect->begin_transaction();
    try {   
        
        $placeBid = $connect->prepare("INSERT INTO bid_listing (bidding_id, customer_id, amount) VALUES (?, ?, ?)");
        $placeBid->bind_param("sss", $payload["bidding_id"], $payload["customer_id"], $payload["amount"]);
        $placeBid->execute();        
        
        if ($placeBid->affected_rows < 0) {
            throw new Exception("We cannot place your bid.");
        }
        $updateHighestBid = $connect->prepare("UPDATE bid_room SET end_amount = ? WHERE bidding_id = ?");
        $updateHighestBid->bind_param("ss", $payload["amount"], $payload["bidding_id"]);
        $updateHighestBid->execute();  
        if ($updateHighestBid->affected_rows < 0) {
            throw new Exception("We cannot place your bid.");
        }

        $updatePriceModel = $connect->prepare("UPDATE diecast_model SET model_price = ? WHERE model_id = ?");
        $updatePriceModel->bind_param("ss", $payload["amount"], $payload["model_id"]);
        $updatePriceModel->execute();  
        if ($updatePriceModel->affected_rows < 0) {
            throw new Exception("We cannot place your bid.");
        }

        $connect->commit();
        return array(
            "title" => "Success", 
            "message" => "Bid placed successfully.",
            "data" => []
        );

    } catch (\Throwable $th) {
        $connect->rollback();
        return array(
            "title" => "Failed", 
            "message" => "Something went wrong! " . $th->getMessage() . " Please try again later",
            "data" => []
        );
    }
}

?>