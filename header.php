<?php
    
    require_once './backend/database/db.php';
        
    $brand = "SELECT * FROM diecast_brand";
    $brandResult = $conn->query($brand);

    $size = "SELECT * FROM diecast_size";
    $sizeResult = $conn->query($size);

    $_SESSION['user_id'] = 3;
?>
<header>
    <div class="top-nav">
        <div class="left-section"> <!-- Wrap logo and navmenu in one container -->
            <a href="#" class="logo"><img src="BG.PNG" alt="Logo"></a>
            <ul class="navmenu">
                <li><a href="index.php">Home</a></li>
                <li class="dropdown">
                    <a href="#" class="nonclickable">Products</a>
                    <ul class="dropdown-menu">
                        <li><a href="Products.php">All Cars</a></li>
                        <li><a href="#" class="model-type-link" data-model-type="Regular">Regular Model</a></li>
                        <li><a href="#" class="model-type-link" data-model-type="Premium">Premium Model</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="nonclickable">Sizes</a>
                    <ul class="dropdown-menu">
                        <?php                            
                            if ($sizeResult->num_rows > 0) {                            
                                while ($row = $sizeResult->fetch_assoc()) {
                                    echo '<li><a href="#" class="size-link" data-size-id="' . htmlspecialchars($row['size_id']) . '
                                    ">' . htmlspecialchars($row['ratio']) . '</a></li>';
                                }
                            } else {
                                echo '<li>No brands available</li>';
                            }
                        ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="nonclickable">Brands</a>
                    <ul class="dropdown-menu">                        
                        <?php                            
                            if ($brandResult->num_rows > 0) {                            
                                while ($row = $brandResult->fetch_assoc()) {
                                    echo '<li><a href="#" class="brand-link" data-brand-id="' . htmlspecialchars($row['brand_id']) . '
                                    ">' . htmlspecialchars($row['brand_name']) . '</a></li>';
                                }
                            } else {
                                echo '<li>No brands available</li>';
                            }
                        ?>
                    </ul>

                </li>
                <li><a href="#">Order</a></li>
            </ul>
        </div>

        <div class="right-icons">
            <div class="search-container">
                <form id="search-form">
                    <input type="text" name="query" placeholder="Search" id="search-query">
                    <button type="submit"><i class='bx bx-search'></i></button>
                </form>
            </div>

            <div class="nav-icons">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Show Cart and Profile icons if user is logged in -->
                    <div class="nav-icon-c">
                        <a href="#" id="cart-icon">
                            <i class='bx bx-cart'></i>
                            <span id="cart-count">0</span>
                        </a>
                    </div>
                    
                    <div class="nav-icon-p">
                        <a href="Profile.php"><i class='bx bx-user-circle'></i></a>
                    </div>
                <?php else: ?>
                    <!-- Show only login icon if user is not logged in -->
                    <div class="nav-icon-p">
                        <a href="Login.php"><i class='bx bx-user-circle'></i></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
</div>
</header>

<script>
    
    let brandFilter = "";
    let sizeFilter = "";
    let modelTypeFilter = "";
    let searchFilter = "";

    document.addEventListener("DOMContentLoaded", function() {        
        const brandLinks = document.querySelectorAll('.brand-link');
        const sizeLinks = document.querySelectorAll('.size-link');
        const modelTypeLink = document.querySelectorAll('.model-type-link');

        const searchForm = document.getElementById('search-form');
                
        searchForm.addEventListener('submit', function(event) {                    
            event.preventDefault();
                        
            searchFilter = document.getElementById('search-query').value;     
            
            getProductWithFilter(
                brandFilter, 
                sizeFilter, 
                modelTypeFilter, 
                searchFilter
            );
        });

        brandLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                
                brandFilter = this.getAttribute('data-brand-id');

                getProductWithFilter(
                    brandFilter, 
                    sizeFilter, 
                    modelTypeFilter, 
                    searchFilter
                );
                
            });
        });
        sizeLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                
                sizeFilter = this.getAttribute('data-size-id');
                getProductWithFilter(
                    brandFilter, 
                    sizeFilter, 
                    modelTypeFilter, 
                    searchFilter
                );
                
            });
        });

        modelTypeLink.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                
                modelTypeFilter = this.getAttribute('data-model-type');                
                getProductWithFilter(
                    brandFilter, 
                    sizeFilter, 
                    modelTypeFilter, 
                    searchFilter
                );
            });
        });


    });
</script>