<?php


function insertCartItem($connect, $payload, $items) {
    $connect->begin_transaction();
    
    try {                
        $cartId = "";

        $checkIfCartExist = $connect->prepare("SELECT cart_id FROM cart WHERE customer_id = ?");
        $checkIfCartExist->bind_param("s", $payload['customer_id']);
        $checkIfCartExist->execute();
        
        $result = $checkIfCartExist->get_result();
        $checkIfCartExist->close();

        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $cartId = $row['cart_id'];

        } else {

            $createCart = $connect->prepare("INSERT INTO cart (customer_id) VALUES (?)");
            $createCart->bind_param("s", $payload["customer_id"]);
            $createCart->execute();

            if ($createCart->affected_rows <= 0) {
                throw new Exception("We cannot save your items in the cart.");
            }

            $cartId = $createCart->insert_id;
        }
        
        
        
        $insertOrUpdateItems = $connect->prepare("SELECT quantity, total FROM cart_items WHERE cart_id = ? AND model_id = ?");

        $updateItem = $connect->prepare("UPDATE cart_items SET quantity = ?, total = ? WHERE cart_id = ? AND model_id = ?");

        $insertItems = $connect->prepare("INSERT INTO cart_items (cart_id, model_id, quantity, total) VALUES (?, ?, ?, ?)");

        foreach ($items as $item) {

                        
            $insertOrUpdateItems->bind_param("ss", $cartId, $item["model_id"]);
            $insertOrUpdateItems->execute();
            $result = $insertOrUpdateItems->get_result();

            if ($result->num_rows > 0) {
                                     
                $updateItem->bind_param("ssss", $item["quantity"], $item["total"], $cartId, $item["model_id"]);
                $updateItem->execute();

                if ($updateItem->affected_rows <= 0) {
                    throw new Exception("We cannot update your items in the cart.");
                }
            } else {
                // Item does not exist, insert a new record
                $insertItems->bind_param("ssss", $cartId, $item["model_id"], $item["quantity"], $item["total"]);
                $insertItems->execute();

                if ($insertItems->affected_rows <= 0) {
                    throw new Exception("We cannot save your items in the cart.");
                }
            }
        }
        
        $connect->commit();

        return array(
            "title" => "Success", 
            "message" => "Item was saved in your cart successfully.", 
            "data" => []
        );

    } catch (\Throwable $th) {
    
        $connect->rollback();

        return array(
            "title" => "Failed", 
            "message" => "Something went wrong! " . $th->getMessage() ." Please try again later",
            "data" => []
        );
    }
}

function deleteCartItem($connect, $modelId, $cartId) {
    try {   
        
        $deleteCartItem = $connect->prepare("DELETE FROM cart_items WHERE model_id = ? AND cart_id = ?");
        $deleteCartItem->bind_param("ss", $modelId, $cartId);
        $deleteCartItem->execute();        
        
        if ($deleteCartItem->affected_rows < 0) {
            throw new Exception("We cannot delete the item in your cart.");
        }

        return array(
            "title" => "Success", 
            "message" => "Cart item removed successfully.",
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

function getCartItem($connect, $customerId) {

    try {

        $getCartItems = $connect->prepare("SELECT 
            cart_items.*, diecast_model.*, diecast_brand.*, diecast_size.*,
            CONCAT(seller.first_name, ' ', seller.last_name) AS seller_name,
            seller.contact_number AS seller_contact,
            seller.address AS seller_address
        FROM cart 
        LEFT JOIN cart_items ON cart_items.cart_id = cart.cart_id
        LEFT JOIN diecast_model ON diecast_model.model_id = cart_items.model_id
        LEFT JOIN diecast_brand ON diecast_brand.brand_id = diecast_model.brand_id
        LEFT JOIN diecast_size ON diecast_size.size_id = diecast_model.size_id
        LEFT JOIN seller ON seller.seller_id = diecast_model.seller_id
        WHERE 
            customer_id = ? AND 
            cart_items.cart_id IS NOT NULL;

        ");
        $getCartItems->bind_param("s", $customerId);
        $getCartItems->execute();
        
        $cart = $getCartItems->get_result();
        $cartItems = $cart->fetch_all(MYSQLI_ASSOC);
        if (count($cartItems) <= 0) {
            return array(
                "title" => "Success", 
                "message" => "No items in cart yet. Add to cart now!", 
                "data" => []);
        }

        return array(
            "title" => "Success", 
            "message" => "Items in the cart retrieved.!", 
            "data" => $cartItems);


    } catch (\Throwable $th) {
         
        return array(
            "title" => "Failed", 
            "message" => "Something went wrong! " . $th->getMessage() ." Please try again later",
            "data" => []
        );
    }
}


?>