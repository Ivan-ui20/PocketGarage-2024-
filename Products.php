<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - PacketGarage</title>

    <!-- CSS-link -->
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>
<body>

    
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/header.php';?>
    
    <section class="ProductsL" id="products-1"> 
        <div class="center-text">
           
        </div>
        <div id="product-list" class="product-container"></div>
    </section>


    <!-- Cart Modal -->
    <div id="cart-modal" class="cart-modal">
        <div class="cart-modal-content">
            <span class="close">&times;</span>
            <ul id="cart-items">
                <!-- Cart items will be dynamically inserted here -->
            </ul>
            <div class="cart-total">
                <strong>Total:</strong> <span id="cart-total-price">₱0.00</span>
            </div>
            <button id="checkout-btn" class="checkout-btn">CHECKOUT</button>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2024 PacketGarage. All rights reserved.</p>
    </footer>

    <script src="java.js"></script>    
    <script src="getProduct.js"></script>
</body>
</html>