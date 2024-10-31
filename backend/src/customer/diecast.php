<?php

    function getDiecastProduct($connect, $brand, $scale, $minPrice, $maxPrice, 
    $modelStock, $modelAvailability, $modelTags, $modelType, $limit, $offset, 
    $modelName) {

        try {
            $query = "SELECT diecast_brand.*,
                diecast_size.*, diecast_model.*,
                CONCAT(seller.first_name, ' ', seller.last_name) AS seller_name,
                seller.contact_number AS seller_contact,
                seller.address AS seller_address            
                FROM diecast_model 
                LEFT JOIN diecast_brand ON diecast_brand.brand_id = diecast_model.brand_id
                LEFT JOIN diecast_size ON diecast_size.size_id = diecast_model.size_id
                LEFT JOIN seller ON seller.seller_id = diecast_model.seller_id
                WHERE 
                    1=1 AND 
                diecast_model.model_price != 0";
            
            $params = [];
            $paramTypes = "";

            if ($brand) {
                $query .= " AND diecast_brand.brand_id = ?";
                $params[] = $brand;
                $paramTypes .= "s";
            }

            if ($scale) {
                $query .= " AND diecast_size.size_id = ?";
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