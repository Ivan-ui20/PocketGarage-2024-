<?php

    // function checkIfItemIsInBidding($connect, $modelId) {
    //     try {
    //         $checkItem = $connect->prepare("SELECT COUNT(*) FROM bid_room WHERE model_id = ?");
    //         $checkItem->bind_param("s", $modelId);
    //         $checkItem->execute();
    //         $result = $checkItem->get_result();
    //         $checkItem->close();            
    //         if ($result->num_rows > 0) {
    //             return true;
    //         }
    //         return false;
    //     } catch (\Throwable $th) {
    //         return true;
    //     }
    // }

    function postBidItem($connect, $payload, $imageUrl) {
        $connect->begin_transaction();
    
        try {
            $addBidItemProduct = $connect->prepare("INSERT INTO diecast_model
                (seller_id, size_id, brand_id, model_name, model_description, 
                model_price, model_stock, model_availability, model_tags, 
                model_type, model_packaging, model_condition, model_image_url) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )");
            
            $addBidItemProduct->bind_param("sssssssssssss", 
                $payload["seller_id"], 
                $payload["size_id"], 
                $payload["brand_id"], 
                $payload["model_name"], 
                $payload["model_description"], 
                $payload["model_price"], 
                $payload["model_stock"], 
                $payload["model_availability"], 
                $payload["model_tags"], 
                $payload["model_type"],
                $payload["model_packaging"], 
                $payload["model_condition"],
                $imageUrl
            );

    
            $addBidItemProduct->execute();
    
            if ($addBidItemProduct->affected_rows <= 0) {
                throw new Exception("We cannot post the bid item.");
            }
    
            $model_id = $addBidItemProduct->insert_id; // corrected from insertId to insert_id
    
            $postBidItem = $connect->prepare("INSERT INTO bid_room(seller_id, model_id, details, 
                start_amount, start_time, end_time) VALUES (?, ?, ?, ?, ?, ?)");
            
            $postBidItem->bind_param("ssssss",  // Adjust data types if needed
                $payload["seller_id"],
                $model_id,
                $payload["details"],
                $payload["start_amount"],
                $payload["start_time"],
                $payload["end_time"]
            );
    
            $postBidItem->execute(); // Added missing execute() call
    
            if ($postBidItem->affected_rows <= 0) {
                throw new Exception("We cannot post the bid item.");
            }
    
            $connect->commit(); 
            return array(
                "title" => "Success", 
                "message" => "Bid item posted successfully", 
                "data" => []
            );
    
        } catch (\Throwable $th) {
            $connect->rollback();
            return array(
                "title" => "Failed", 
                "message" => "Something went wrong! " . $th->getMessage() . 
                    " Please try again later",
                "data" => []
            );
        }
    }

    function cancelBidItem($connect, $bidding_id) {
                
        try {        
            $status = "Closed";
            $updateStatus = $connect->prepare("UPDATE bid_room 
                SET bid_status = ? WHERE bidding_id = ?");
            $updateStatus->bind_param("ss", 
                $status,
                $bidding_id
            );
    
            $updateStatus->execute();
            
            if ($updateStatus->affected_rows <= 0) {
                throw new Exception("Failed to update the bid status to Closed.");
            }
                
            return array(
                "title" => "Success", 
                "message" => "Bid status updated to Closed successfully.", 
                "data" => []
            );
    
        } catch (\Throwable $th) {
            return array(
                "title" => "Failed", 
                "message" => "Something went wrong! " . $th->getMessage() . 
                    " Please try again later",
                "data" => []
            );
        }
    }
    
    
    function closeBidItem($connect, $payload) {
        $connect->begin_transaction();
        try {
            
            $status = "Closed";
            $closeBidItem = $connect->prepare("UPDATE bid_room 
                SET bid_status = ? WHERE bidding_id = ?");
            $closeBidItem->bind_param("ss", 
                $status,
                $payload["bidding_id"]
            );
    
            $closeBidItem->execute(); 
    
            if ($closeBidItem->affected_rows <= 0) {
                throw new Exception("We cannot close the bid item.");
            }
                
            $fetchModelId = $connect->prepare("SELECT model_id FROM bid_room WHERE bidding_id = ?");
            $fetchModelId->bind_param("s", $payload["bidding_id"]);
            $fetchModelId->execute();
            $result = $fetchModelId->get_result();
    
            if ($result->num_rows <= 0) {
                throw new Exception("Model ID not found for the given bidding ID.");
            }
    
            $row = $result->fetch_assoc();
            $model_id = $row['model_id'];
                
            $model_status = "Not Available";
            $model_stock = 0;
            $removeItemStock = $connect->prepare("UPDATE diecast_model 
                SET model_stock = ?, model_availability = ? 
                WHERE model_id = ?");
            $removeItemStock->bind_param("iss", 
                $model_stock,
                $model_status,
                $model_id
            );
    
            $removeItemStock->execute(); 
    
            if ($removeItemStock->affected_rows <= 0) {
                throw new Exception("Failed to update the model stock and availability.");
            }
                
            $connect->commit(); 
            return array(
                "title" => "Success", 
                "message" => "Bid item closed successfully", 
                "data" => []
            );
    
        } catch (\Throwable $th) {            
            $connect->rollback();
            return array(
                "title" => "Failed", 
                "message" => "Something went wrong! " . $th->getMessage() . 
                    " Please try again later",
                "data" => []
            );
        }
    }    
    function getBidItem($connect, $sellerId) {
        try {
            $getBidPost = $connect->prepare("SELECT 
                    bid_room.bidding_id,
                    bid_room.seller_id,
                    bid_room.model_id,
                    bid_room.details,
                    bid_room.start_amount,
                    bid_room.end_amount,
                    bid_room.start_time,
                    bid_room.end_time,
                    diecast_size.ratio,
                    diecast_brand.brand_name,
                    diecast_model.model_name,
                    diecast_model.model_description,
                    diecast_model.model_tags,
                    diecast_model.model_type,
                    diecast_model.model_image_url                    
                FROM 
                    bid_room
                LEFT JOIN 
                    diecast_model ON diecast_model.model_id = bid_room.model_id
                LEFT JOIN 
                    diecast_size ON diecast_size.size_id = diecast_model.size_id
                LEFT JOIN 
                    diecast_brand ON diecast_brand.brand_id = diecast_model.brand_id
                WHERE 
                    bid_room.seller_id = ?");
            $getBidPost->bind_param("s", $sellerId);
            $getBidPost->execute();

            $bidPost = $getBidPost->get_result();
            $bidPosts = $bidPost->fetch_all(MYSQLI_ASSOC);

            if (count($bidPosts) <= 0) {
                return array(
                    "title" => "Success", 
                    "message" => "You don't have any bid post yet. Go post your item now for your first bid post.", 
                    "data" => []);
            }
    
            return array(
                "title" => "Success", 
                "message" => "bid post retrieved!", 
                "data" => $bidPosts);

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