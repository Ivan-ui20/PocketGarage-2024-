<?php

    function getDiecastProduct($connect) {
        try {
            
            $getDiecastProducts = $connect->prepare("SELECT diecast_brand.*,
                diecast_size.*, diecast_model.*,
                CONCAT(seller.first_name, ' ', seller.last_name) AS seller_name,
                seller.contact_number AS seller_contact,
                seller.address AS seller_address            
                FROM diecast_model 
                LEFT JOIN diecast_brand ON diecast_brand.brand_id = diecast_model.brand_id
                LEFT JOIN diecast_size ON diecast_size.size_id = diecast_model.size_id
                LEFT JOIN seller ON seller.seller_id = diecast_model.seller_id
            ");            
            $getDiecastProducts->execute();
        
            $products = $getDiecastProducts->get_result();
            $diecastProducts = $products->fetch_all(MYSQLI_ASSOC);

            if (count($diecastProducts) <= 0) {
                return array(
                    "title" => "Success", 
                    "message" => "There's no diecast product yet.", 
                    "data" => []);
            }

            return array(
                "title" => "Success", 
                "message" => "Products retrieved.!", 
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