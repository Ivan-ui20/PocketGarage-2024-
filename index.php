<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PocketGarage</title>

    <!-- CSS-link -->
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>
<body>
    
<!-- copy and paste this to the page para may header sila (if need nila ng header) -->
    <?php include './header.php';?>
   
    <section class="main-home">
        <div class="slider">
            <div class="slides">
                <input type="radio" name="radio-btn" id="radio1" checked>
                <input type="radio" name="radio-btn" id="radio2">
                <input type="radio" name="radio-btn" id="radio3">
                <div class="slide first">
                    <img src="BGM.jpg" alt="Image 1">
                </div>
                <div class="slide">
                    <img src="BGM3.jpg" alt="Image 2">
                </div>
                <div class="slide">
                    <img src="BGM4.jpg" alt="Image 3">
                </div>
                <div class="navigation-auto">
                    <div class="auto-btn1"></div>
                    <div class="auto-btn2"></div>
                    <div class="auto-btn3"></div>
                </div>
            </div>
            <div class="navigation-manual">
                <label for="radio1" class="manual-btn"></label>
                <label for="radio2" class="manual-btn"></label>
                <label for="radio3" class="manual-btn"></label>
            </div>
        </div>
    </section>

    <section class="ProductsL" id="products-1"> 
        <div class="center-text">
           
        </div>
        
        <div id="product-list" class="product-container">    </div>

    </section>

    <!-- Product Details Modal -->
<div id="productDetailsModal" class="modal">
    <span class="close">&times;</span> <!-- Close button -->
    <div class="modal-content">
        <div class="modal-image">
            <img id="productImage" src="" alt="Product Image">
        </div>
        <div class="modal-details">
            <button class="close-modal" id="closeModalBtn">&times;</button> <!-- Close button -->
            <h2 id="productName">Product Name</h2>
            <p id="productPrice">Product Price</p>
            <p id="productDescription">Product Description goes here.</p> <!-- Placeholder for description -->
            <button id="modalAddToCartBtn" class="action-button">Add to Cart</button>
            <button id="checkoutButton" class="action-button">Checkout</button>
            <button id="chatButton" class="action-button">Chat</button>
        </div>
    </div>
</div>

<!-- Cart Modal -->
<div id="cart-modal" class="cart-modal">
    <div class="cart-modal-content">
        <h4 class="">Cart</h4>
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

<!-- Checkout Modal -->
<div id="checkout-modal" class="checkout-modal" style="display: none;">
    <div class="checkout-modal-content">
        <h4>Checkout</h4>
        <span class="close-checkout">&times;</span>
        
        <!-- Product Details Section -->
        <div id="checkout-product-list" class="checkout-product-list">
            <!-- Product items will be dynamically inserted here -->
        </div>

        <div class="checkout-total">
            <p><strong>Total Price:</strong> <span id="checkout-total-price">₱0.00</span></p>
        </div>

        <form id="checkout-form">

            <button type="submit" class="submit-checkout">Place Order</button>
        </form>
    </div>
</div>

    <div class="view-more">
        <a href="Products.php" class="view-more-btn">View More</a>
    </div>

    <footer class="footer">
        <p>&copy; 2024 PocketGarage. All rights reserved.</p>
    </footer>

    <script src="getProduct.js"></script>
    <script src="java.js"></script>
    
</body>

</html>