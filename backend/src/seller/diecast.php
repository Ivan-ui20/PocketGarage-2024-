<?php

    
    function addDiecastProduct($connect, $payload, $imageUrl) {
        try {
            $addDiecastProduct = $connect->prepare("INSERT INTO diecast_model
                (seller_id, size_id, brand_id, model_name, model_description, 
                model_price, model_stock, model_availability, model_tags, 
                model_type, model_image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            // Bind parameters including the image URL
            $addDiecastProduct->bind_param("sssssssssss", 
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
                $imageUrl
            );

            $addDiecastProduct->execute();

            if ($addDiecastProduct->affected_rows <= 0) {
                throw new Exception("We cannot create your new product.");
            }

            return array(
                "title" => "Success", 
                "message" => "Product added successfully.",
                "data" => []
            );

        } catch (\Throwable $th) {
            return array(
                "title" => "Failed", 
                "message" => "Something went wrong! " . $th->getMessage() . " Please try again later",
                "data" => []
            );
        }
    }

    function editDiecastProduct($connect, $payload, $imageUrl) {
        try {
            
        } catch (\Throwable $th) {
            return array(
                "title" => "Failed", 
                "message" => "Something went wrong! " . $th->getMessage() . " Please try again later",
                "data" => []
            );
        }
    }

    function deleteDiecastProduct($connect, $modelId, $sellerId) {
        try {
            
        } catch (\Throwable $th) {
            return array(
                "title" => "Failed", 
                "message" => "Something went wrong! " . $th->getMessage() . " Please try again later",
                "data" => []
            );
        }
    }

    function getDiecastProduct($connect, $sellerId) {
        try {
            
            $getDiecastProducts = $connect->prepare("SELECT diecast_brand.*,
                diecast_size.*, diecast_model.*            
                FROM diecast_model 
                LEFT JOIN diecast_brand ON diecast_brand.brand_id = diecast_model.brand_id
                LEFT JOIN diecast_size ON diecast_size.size_id = diecast_model.size_id
                WHERE seller_id = ?");
            $getDiecastProducts->bind_param("s", $sellerId);
            $getDiecastProducts->execute();
        
            $products = $getDiecastProducts->get_result();
            $diecastProducts = $products->fetch_all(MYSQLI_ASSOC);

            if (count($diecastProducts) <= 0) {
                return array(
                    "title" => "Success", 
                    "message" => "You don't have post any product yet. Post your first product now!", 
                    "data" => []);
            }
    
            return array(
                "title" => "Success", 
                "message" => "Your products retrieved.!", 
                "data" => $diecastProducts);

        } catch (\Throwable $th) {
            return array(
                "title" => "Failed", 
                "message" => "Something went wrong! " . $th->getMessage() . " Please try again later",
                "data" => []
            );
        }
    }

?>