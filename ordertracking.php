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
    <title>User Profile</title>
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
        
         <!-- Order Info Section -->
    <div class="order-info">
        <p>Order ID: #123456</p>
        <p>Order Status:</p>
        <!-- Order Status Timeline -->  
        <div class="order-timeline">
          
            <!-- Add dynamic classes to show the current status -->
            <div class="order-step active" id="step-1">
                <div class="icon">✔️</div>
                <p>Order Placed</p>
            </div>
            <div class="order-step current" id="step-2"> <!-- Current status -->
                <div class="icon">🚚</div>
                <p>Shipped</p>
            </div>
            <div class="order-step" id="step-3">
                <div class="icon">📦</div>
                <p>Out for Delivery</p>
            </div>
            <div class="order-step" id="step-4">
                <div class="icon">🏠</div>
                <p>Delivered</p>
            </div>
            <div class="order-step" id="step-5">
                <div class="icon">📬</div>
                <p>Received</p>
            </div>
        </div>

        <!-- Conditionally display the "Order Received" button if the order is delivered -->
        <?php 
        $order_status = "delivered";  // Example: This value would come from your database or session

        if ($order_status === "delivered"): ?>
            <button onclick="orderReceived()">Order Received</button>
        <?php endif; ?>
        
    </div>
      


    <!-- Cart Modal -->
    <?php include './shared/cartModal.php';?>
    <!-- Checkout Modal -->


    <div class="footer">
        <?php include './shared/footer.php';?>
    </div>

    <?php include './shared/userAgreementModal.php';?>

   
</body>
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