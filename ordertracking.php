<?php
    require_once './backend/database/db.php';
    session_start();

    if($_SESSION['user_id']) {
        header("index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking</title>
    <!-- CSS-link -->
    <link rel="stylesheet" href="MyProfile.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
</head>
<body>
    <?php include './shared/header.php';?>

    <div class="order-tracking-container">
        <h1>Order Tracking</h1>
        <?php
            function getStepIcon($step) {
                $icons = [
                    "Order Placed" => "✔️",
                    "Shipped" => "🚚",
                    "Out for Delivery" => "📦",
                    "Delivered" => "🏠",
                    "Received" => "📬"
                ];
                return $icons[$step] ?? "❓";
            }
        ?>
        <?php 
            $getOrder = $conn->prepare("SELECT 
                order_info.order_id,
                order_info.shipping_addr,
                order_info.order_ref_no,
                order_info.order_total,
                order_info.order_payment_option,
                order_info.order_status,
                order_info.created_at,
                
                GROUP_CONCAT(
                    CONCAT(
                        '{current_track: ', order_tracker.current_track, ', tracker_date: ', order_tracker.created_at, '}'
                    ) SEPARATOR ', '
                ) AS order_tracker_info,
                
                GROUP_CONCAT(
                    CONCAT(
                        '{model_name: ', diecast_model.model_name,
                        ', brand_name: ', diecast_brand.brand_name,
                        ', ratio: ', diecast_size.ratio,
                        ', model_description: ', diecast_model.model_description,
                        ', model_price: ', diecast_model.model_price,
                        ', model_stock: ', diecast_model.model_stock,
                        ', model_availability: ', diecast_model.model_availability,
                        ', model_tags: ', diecast_model.model_tags,
                        ', model_type: ', diecast_model.model_type,
                        ', model_image_url: ', diecast_model.model_image_url,
                        ', seller_name: ', CONCAT(seller.first_name, ' ', seller.last_name),
                        ', contact_number: ', seller.contact_number, '}'
                    ) SEPARATOR ', '
                ) AS diecast_model_info

            FROM order_info 
            LEFT JOIN order_items ON order_items.order_id = order_info.order_id
            LEFT JOIN order_tracker ON order_tracker.order_id = order_info.order_id
            LEFT JOIN diecast_model ON diecast_model.model_id = order_items.model_id
            LEFT JOIN diecast_size ON diecast_size.size_id = diecast_model.size_id
            LEFT JOIN diecast_brand ON diecast_brand.brand_id = diecast_model.brand_id
            LEFT JOIN seller ON seller.seller_id = diecast_model.seller_id
            WHERE order_info.customer_id = ?
            GROUP BY order_info.order_id
            ORDER BY order_info.created_at DESC;");
            $getOrder->bind_param("s", $_SESSION['user_id']);
            $getOrder->execute();
            $result = $getOrder->get_result();
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = htmlspecialchars($row['order_id']);
                    $orderId = htmlspecialchars($row['order_ref_no']);
                    $orderStatus = htmlspecialchars($row['order_status']);
                    $createdAt = new DateTime($row['created_at']);
                    $formattedDate = $createdAt->format('F j, Y, H:i');
            
                    // Parse order tracking info JSON
                    $orderTrackerInfo = json_decode("[" . $row['order_tracker_info'] . "]", true);
                    
                    // Parse diecast model info JSON
                    $diecastModelInfo = json_decode("[" . $row['diecast_model_info'] . "]", true);
                    ?>
            
                    <!-- Display order information -->
                    <div class="order-info">
                        <p>Order ID: <?php echo $orderId; ?></p>
                        <p>Order Status: <?php echo ucfirst($orderStatus); ?></p>
                        <p>Order Date: <?php echo $formattedDate; ?></p>
            
                        <!-- Order Status Timeline -->
                        <div class="order-timeline">
                            <?php
                            // Define possible steps for timeline
                            $steps = ["Order Placed", "Shipped", "Out for Delivery", "Delivered", "Received"];
                            foreach ($steps as $index => $step) {
                                // Determine if this step is completed or current
                                $isActive = ($index <= array_search($orderStatus, array_map('strtolower', $steps)));
                                $isCurrent = (strtolower($step) == strtolower($orderStatus));
                                $stepClass = $isCurrent ? "current" : ($isActive ? "active" : "");
            
                                echo "<div class='order-step {$stepClass}' id='step-" . ($index + 1) . "'>";
                                echo "<div class='icon'>" . getStepIcon($step) . "</div>";
                                echo "<p>{$step}</p>";
                                echo "</div>";
                            }
                            ?>
                        </div>
            
                        <!-- Conditionally display the "Order Received" button -->
                        <?php if (strtolower($orderStatus) === "delivered"): ?>
                            <button onclick="orderReceived(<?php echo $id ?>)">Order Received</button>
                        <?php endif; ?>
                    </div>
                    <?php
                }
            }
        ?>                
    </div>
      
    <!-- Cart Modal -->
    <?php include './shared/cartModal.php';?>
    <!-- Checkout Modal -->


    <div class="footer">
        <?php include './shared/footer.php';?>
    </div>

    <?php include './shared/userAgreementModal.php';?>

   
</body>
<script>

    function orderReceived(id) {
        const data = new URLSearchParams({
            order_id: id,
            status: "Received"
        });

        fetch("/backend/src/customer/route.php?route=customer/order/update", {
            method: "POST",
            body: data.toString(),
            headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            },
        })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then((data) => {
            alert(data.message)
            
        })
        .catch((error) => {
            console.error("There was a problem with the fetch operation:", error);
        });
    }

    
</script>
</html>

<style>

body .order-tracking-container {
    background-color: #f9f9f9;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0; /* Remove default margin */

}

.order-tracking-container {
    background-color: #fff;
    padding: 50px;
    border-radius: 10px;
    width: 100%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: left;
}
h1 {
    font-size: 24px;
    margin-bottom: 10px;
}

.order-info p {
    font-size: 14px;
    color: #555;
    margin-bottom: 10px;
    text-align: left;
}

.order-info {
    font-size: 14px;
    color: #555;
    margin-bottom: 20px; /* Increased margin to create more space between sections */
    padding: 10px;
    background-color: #f3f3f3; /* Light gray background */
    border-radius: 5px;
    border-bottom: 1px solid #ddd; /* Light gray border at the bottom */
    flex-direction: column;
    align-items: center;  /* Centers content horizontally */
    justify-content: center;  /* Centers content vertically */
    text-align: center;  /* Ensures text is centered */
    margin-top: 20px;
}



.order-timeline {
    display: flex;
    margin-top: 20px;
    margin-bottom: 20px;
    position: relative;
    background-color: #f5f5f5; /* Light grey background */
    padding: 10px;  /* Add some padding for better spacing */
    border-radius: 8px; /* Optional: Slightly round the corners for a smoother look */
    gap: 50px;
    justify-content: center;
}

.order-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    color: #aaa;
    width: 150px; /* Decrease width to make each step smaller */
    transition: color 0.3s;
}

.order-step.active {
    color: navy;
}
.order-step.current {
  background-color: #28a745;  /* Green background for active step */
    color: #fff;  /* White text color */
    padding: 3px;  /* Add some padding for better visibility */
    border-radius: 50px;  /* Apply a rounded border to make it stand out */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);  /* Add a subtle shadow to make it pop */
    transition: all 0.3s ease;  /* Smooth transition for visual effects */
}


.icon {
    font-size: 24px;
    margin-bottom: 5px;
}

button {
    padding: 10px 20px;
    background-color: #28a745;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
    margin-top: 20px;  /* Space above the button */
    width: auto;  /* Button size should be auto */
    
}

button:hover {
    background-color: #218838;
}

button.received {
    background-color: #007bff;  /* Blue color */
}

button.received:hover {
    background-color: #0056b3;
}
</style>