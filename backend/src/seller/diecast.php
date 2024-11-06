<?php
    
    function addDiecastProduct($connect, $payload, $imageUrl) {
        try {
            $addDiecastProduct = $connect->prepare("INSERT INTO diecast_model
                (seller_id, size_id, brand_id, model_name, model_description, 
                model_price, model_stock, model_availability, model_tags, 
                model_type, model_packaging, model_condition, model_image_url) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )");
            
            $addDiecastProduct->bind_param("sssssssssssss", 
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

    function editDiecastProduct($connect, $payload) {
        try {
            
            $updateDiecastProduct = $connect->prepare("UPDATE diecast_model 
            SET model_name = ?, model_description = ?, 
            model_price = ?, model_availability = ?
            WHERE seller_id = ? AND model_id = ?");
            
            $updateDiecastProduct->bind_param("ssssss",
                $payload["model_name"],
                $payload["model_description"], 
                $payload["model_price"],                 
                $payload["model_availability"],                 
                $payload["seller_id"],
                $payload["model_id"], 
            );

            $updateDiecastProduct->execute();

            if ($updateDiecastProduct->affected_rows <= 0) {
                throw new Exception("We cannot update your product.");
            }

            return array(
                "title" => "Success", 
                "message" => "Product updated successfully.",
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

    function deleteDiecastProduct($connect, $modelId, $sellerId) {
        try {

            $deleteDiecastProduct = $connect->prepare("DELETE FROM diecast_model 
                WHERE seller_id = ? AND model_id = ?");
            $deleteDiecastProduct->bind_param("ss", $sellerId, $modelId);
            $deleteDiecastProduct->execute();

            if ($deleteDiecastProduct->affected_rows < 0) {
                throw new Exception("We cannot delete your product.");
            }
            return array(
                "title" => "Success", 
                "message" => "Product deleted successfully.",
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

    function getDiecastProduct($connect, $sellerId, $brand, $scale, 
    $minPrice, $maxPrice, $modelStock, $modelAvailability, $modelTags, 
    $modelType, $limit, $offset, $modelName) {

        try {
            
            $query = "SELECT diecast_brand.*, diecast_size.*, diecast_model.* 
                  FROM diecast_model 
                  LEFT JOIN diecast_brand ON diecast_brand.brand_id = diecast_model.brand_id
                  LEFT JOIN diecast_size ON diecast_size.size_id = diecast_model.size_id
                  WHERE diecast_model.seller_id = ?";
                
            $params = [$sellerId];
            $paramTypes = "s"; 
                    
            if ($brand) {
                $query .= " AND diecast_brand.brand_name = ?";
                $params[] = $brand;
                $paramTypes .= "s";
            }

            if ($scale) {
                $query .= " AND diecast_size.ratio = ?";
                $params[] = $scale;
                $paramTypes .= "s";
            }

            if ($minPrice !== null) {
                $query .= " AND diecast_model.model_price >= ?";
                $params[] = $minPrice;
                $paramTypes .= "d";
            }

            if ($maxPrice !== null) {
                $query .= " AND diecast_model.model_price <= ?";
                $params[] = $maxPrice;
                $paramTypes .= "d";
            }

            if ($modelStock !== null) {
                $query .= " AND diecast_model.model_stock >= ?";
                $params[] = $modelStock;
                $paramTypes .= "i";
            }

            if ($modelAvailability !== null) {
                $query .= " AND diecast_model.model_availability = ?";
                $params[] = $modelAvailability;
                $paramTypes .= "s";
            }

            if ($modelTags) {                
                $tags = explode(',', $modelTags);
                foreach ($tags as $tag) {
                    $tag = trim($tag);
                    $query .= " AND diecast_model.model_tags LIKE ?";
                    $params[] = "%" . $tag . "%";
                    $paramTypes .= "s";
                }
            }

            if ($modelType) {
                $query .= " AND diecast_model.model_type = ?";
                $params[] = $modelType;
                $paramTypes .= "s";
            }

            if ($modelName) {
                $query .= " AND diecast_model.model_name LIKE ?";
                $params[] = "%" . $modelName . "%";
                $paramTypes .= "s";
            }
            
            $query .= " LIMIT ? OFFSET ?";
            $params[] = $limit;
            $params[] = $offset;
            $paramTypes .= "ii";
            
            $getDiecastProducts = $connect->prepare($query);
            $getDiecastProducts->bind_param($paramTypes, ...$params);
            $getDiecastProducts->execute();
            
            $result = $getDiecastProducts->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);

            return [
                "title" => "Success",
                "message" => "Products retrieved successfully.",
                "data" => $data
            ];

        } catch (\Throwable $th) {
            return array(
                "title" => "Failed", 
                "message" => "Something went wrong! " . $th->getMessage() . " Please try again later",
                "data" => []
            );
        }
    }

?>