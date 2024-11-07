<?php
    
    require_once './backend/database/db.php';
        
    $brand = "SELECT * FROM diecast_brand";
    $brandResult = $conn->query($brand);

    $size = "SELECT * FROM diecast_size";
    $sizeResult = $conn->query($size);
        
?>


<header>
    <div class="top-nav">
        <div class="left-section"> <!-- Wrap logo and navmenu in one container -->
            <a href="#" class="logo"><img src="./assets/BG.PNG" alt="Logo"></a>
            <ul class="navmenu">
                <li><a href="index.php">Home</a></li>
                <li class="dropdown">
                    <a href="#" class="nonclickable">Products</a>
                    <ul class="dropdown-menu">
                        <li><a href="Products.php">All Cars</a></li>
                        <li><a href="#" class="model-type-link" data-model-type="Regular">Regular Model</a></li>
                        <li><a href="#" class="model-type-link" data-model-type="Premium">Premium Model</a></li>
                        <li><a href="#" class="model-type-link" data-model-type="Bidding">Bidding</a></li>                        
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="nonclickable">Scale</a>
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
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="#">Order</a></li>
                <?php endif; ?>

            </ul>
        </div>

        <div class="right-icons">
            <div class="search-container">
                <form id="search-form">
                    <input type="text" name="query" placeholder="Search" id="search-query">
                    <button type="submit"><i class='bx bx-search'></i></button>
                </form>
            </div>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Show Cart and Profile icons if user is logged in -->
                <div class="nav-icon-c">
                    <a href="#" id="cart-icon">
                        <i class='bx bx-cart'></i>
                        <span id="cart-count">0</span>
                    </a>
                </div>
                
              <!-- Profile Icon with Dropdown Menu -->
                <div class="nav-icon-p">
                    <a href="#" id="profile-icon">
                        <div class="header-profile-pic-container">
                        <div class="header-user-img">
                            <img src="<?php echo $avatar; ?>" id="photo" alt="Profile Picture">            
                        </div>
                    </div>
                    </a>
                    
                    <!-- Dropdown Menu -->
                    <div class="profile-dropdown" id="profile-dropdown">
                        <a href="MyProfile.php">My Profile</a>
                        <a href="chatModal.php">Message</a>
                        <a href="SellerLogin.php">Switch to Seller (<span id="seller-status">Pending</span>)</a>
                        <a onclick="logout()">Logout</a>
                  
                    </div>
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

    function logout () {
        sessionStorage.clear();                
        window.location.href = "shared/logout.php"
    }
</script>

<script>
    
    // Toggle submenu display on click (optional for touch devices)


    // document.addEventListener('DOMContentLoaded', function() {
    //     const dropdown = document.querySelector('.navmenu .dropdown');

    //     dropdown.addEventListener('click', function(event) {
    //         event.stopPropagation();
    //         this.querySelector('.submenu').classList.toggle('show');
    //     });

    //     document.addEventListener('click', function() {
    //         document.querySelector('.submenu').classList.remove('show');
    //     });
    // });

    // Searchbar
    document.addEventListener('DOMContentLoaded', function() {
        // Get the search query from the URL
        const urlParams = new URLSearchParams(window.location.search);
        const query = urlParams.get('query') ? urlParams.get('query').toLowerCase() : '';

        // Select all product boxes
        const productBoxes = document.querySelectorAll('.product-box');

        // If there's a search query, filter products based on the query
        if (query) {
            productBoxes.forEach(box => {
                const productName = box.querySelector('.product-text h4').innerText.toLowerCase();
                // Check if product name includes the query
                if (productName.includes(query)) {
                    box.classList.remove('hidden'); // Show product if it matches the query
                } else {
                    box.classList.add('hidden'); // Hide product if it does not match the query
                }
            });
    }
});
        //profile//
        // Toggle profile dropdown on icon click
        document.getElementById('profile-icon').addEventListener('click', function () {
            const dropdown = document.getElementById('profile-dropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });

        // Close the dropdown if clicked outside
        window.addEventListener('click', function (e) {
            const profileIcon = document.getElementById('profile-icon');
            const dropdown = document.getElementById('profile-dropdown');
            if (e.target !== profileIcon && !profileIcon.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
</script>