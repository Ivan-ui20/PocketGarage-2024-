<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - PacketGarage</title>

    <!-- CSS-link -->
    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>
<body>

    
    <?php include './shared/header.php';?>
    
    <section class="ProductsL" id="products-1"> 
        <div class="center-text">
           
        </div>
        <div id="product-list" class="product-container"></div>
    </section>


    <!-- Cart Modal -->
    <?php include './shared/cartModal.php';?>
    <!-- Checkout Modal -->
    <?php include './shared/checkoutModal.php';?>

    <footer class="footer">
        <p>&copy; 2024 PacketGarage. All rights reserved.</p>
    </footer>

    <script src="./scripts/getProduct.js"></script>
    <script src="./scripts/java.js"></script>
    
</body>
</html>