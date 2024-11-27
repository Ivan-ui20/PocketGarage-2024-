<?php

    function getDiecastProduct($connect, $brand, $scale, $minPrice, $maxPrice, 
    $modelStock, $modelAvailability, $modelTags, $modelType, $limit, $offset, 
    $modelName, $bidding) {

        try {
            $query = "SELECT diecast_brand.*,
                diecast_size.*, diecast_model.*,
                CONCAT(customer.first_name, ' ', customer.last_name) AS seller_name,
                customer.contact_number AS seller_contact,
                customer.address AS seller_address,
                bid_room.bidding_id,
                bid_room.details,
                bid_room.start_time,
                bid_room.end_time,
                bid_room.end_amount,
                bid_room.start_amount,
                bid_room.bid_status,
                bid_room.appraisal_value           
                FROM diecast_model      
                LEFT JOIN diecast_brand ON diecast_brand.brand_id = diecast_model.brand_id
                LEFT JOIN diecast_size ON diecast_size.size_id = diecast_model.size_id
                LEFT JOIN seller ON seller.seller_id = diecast_model.seller_id
                LEFT JOIN customer ON customer.customer_id = seller.user_id
                LEFT JOIN bid_room ON bid_room.model_id = diecast_model.model_id
                WHERE 
                    1=1";
            
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
            
            if ($modelType) {
                $query .= " AND diecast_model.model_type = ?";
                $params[] = $modelType;
                $paramTypes .= "s";
            } else {
                $query .= " AND diecast_model.model_type != 'Bidding'";           
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