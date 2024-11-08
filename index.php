<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PocketGarage</title>

    <!-- CSS-link -->
    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="./Modal/productModal.css"> -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>
<body>

<!-- copy and paste this to the page para may header sila (if need nila ng header) -->
    <?php include './Modal/bidModal.php';?>
    <?php include './Modal/productModal.php';?>
    <?php include './shared/header.php';?>
    <?php include './shared/slider.php';?>
    

    <section class="ProductsL" id="products-1"> 
        <div class="center-text">
           
        </div>
        
        <div id="product-list" class="product-container"></div>

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
        <?php include './shared/cartModal.php';?>        
        <!-- Checkout Modal -->
        <?php include './shared/checkoutModal.php';?>

    <div class="view-more">
        <a href="Products.php" class="view-more-btn">View More</a>
    </div>

    <div class="footer">

    <?php include './shared/footer.php';?>
    </div>

    

    <?php include './shared/userAgreementModal.php';?>
   
               
</body>

<script src="./scripts/getProduct.js"></script>
<script src="./scripts/java.js"></script>

</html>