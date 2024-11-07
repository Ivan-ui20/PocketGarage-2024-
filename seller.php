
<?php

require_once './backend/database/db.php';
session_start();

if($_SESSION['seller_id']) {
  header("index.php");
}

$brand = "SELECT * FROM diecast_brand";
$brandResult = $conn->query($brand);

if ($brandResult) {    
    $brandData = $brandResult->fetch_all(MYSQLI_ASSOC);
    $brandResult->free(); 
} else {
    $brandData = [];
}


$size = "SELECT * FROM diecast_size";
$sizeResult = $conn->query($size);

if ($sizeResult) {
    $sizeData = $sizeResult->fetch_all(MYSQLI_ASSOC);
    $sizeResult->free(); 
} else {
    $sizeData = [];
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pocket Garage - Seller</title>

    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
    />

    <link rel="stylesheet" href="css/seller.css" />
    <style>
      /* Hide all sections by default */
      .section {
        display: none;
      }

      /* Show the section when the 'visible' class is added */
      .visible {
        display: block;
      }

      nav ul {
        list-style: none;
        padding: 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
      }

      nav ul li {
        margin: 10px;
      }

      .btn {
        padding: 10px;
        margin-top: 10px;
      }

      .sell-btn {
        background-color: green;
        color: white;
      }

      .cancel-btn {
        background-color: red;
        color: white;
      }

      body {
        background: url('assets/bgl.png');
        background-size: cover;
      } 
    </style>


  </head>

  <body>
    <nav>
      <div id="sidebar">
            <ul class="sidebar">
              <li onclick="hideSidebar()">
                <a href="#">
                  <span class="material-symbols-outlined">close</span>
                </a>
              </li>
            <li class="dropdown">
              <a href="javascript:void(0)" class="dropdown-btn" onclick="toggleDropdown('manage-products-dropdown')">
                <span class="material-symbols-outlined">inventory</span>
                <h3>Manage Products</h3>
                <span class="dropdown-arrow">▼</span>
              </a>
              <ul id="manage-products-dropdown" class="dropdown-content">
                  <li><a href="#" onclick="showSection('view-product-section')">
                    <span class="material-symbols-outlined">storefront</span>
                      <h3>View Products</h3>
                    </a>
                  </li>
                  <li><a href="#" onclick="showSection('add-product-section')">
                  <span class="material-symbols-outlined">sell</span>
                      <h3>Add Product</h3>
                  </a>
                </li>
                  <li>
                  <a href="#" onclick="showSection('orders-section')">
                    <span class="material-symbols-outlined">receipt_long</span>
                  <h3>Orders</h3>
                 </a>
                 </li>

                  <li>
                 <a href="#" onclick="showSection('customers-section')">
                  <span class="material-symbols-outlined">group</span>
                  <h3>Customers</h3>
                </a>
               </li>
              </ul>
            </li>
            <li>
              <a href="#" onclick="showSection('auction-section')">
              <span class="material-symbols-outlined">shopping_basket</span>
                <h3>Auction</h3>
              </a>
            </li>
            <li>
              <a href="#" onclick="showSection('message-section')">
                <span class="material-symbols-outlined">mail</span>
                <h3>Messages</h3>
                <span class="msg_count">3</span>
              </a>
            </li>
            <li>
              <a href="Login.php">
                <span class="material-symbols-outlined">lab_profile</span>
                <h3>Switch to Buyer</h3>
              </a>
            </li>
            <li>
                <a href="shared/logout.php">
                <span class="material-symbols-outlined">logout</span>
                <h3>Logout</h3>
              </a>
            </li>
          </ul>
      </div>

      <div id="nav-bar">
        <ul>
          <li>
            <a href="#" class="logo" onclick="showSection('dashboard-section')">
              <img src="./assets/BG.PNG" alt="Logo" />
            </a>
          </li>
        
          <li class="profile"  >
            <div class="Info">
              <p><b><?php echo $_SESSION["seller_name"]?></b></p>
              <p>Verified Seller</p>
            </div>

            <div class="profile-photo"  onclick="showSection('user-profile-section')">
              <img src="assets/profile.jpeg" alt="" />
              
            </div>
              
          </li>
            
          <li class="menubtn" onclick="showSidebar()">  
            <a href="#">
              <span class="material-symbols-outlined">menu</span>
            </a>            
          </li>
        </ul>
      </div>
    </nav>

    <!-- For Dashboard Section -->
    <div class="content">
        <input id="seller-id" type="text" hidden value="<?php echo $_SESSION["seller_id"]?>">
        <!-- Dashboard Section -->
        <div id="dashboard-section" class="section">
            <h1>Overview</h1>

          <!--start orecentupdate-->
          
          <div class="recent_update">
            <h2>Recent Update</h2>

            <div class="form">
              <div class ="Update">
                <div class="message">
                  <p><b>Ivan Sisgado</b> Received order</p>
                </div>
              </div>
            </div>
                        
        </div>

        <div class="all_products">
            <h2>All Products</h2>

            <div class="form">
            <a href="#" class="logo" onclick="showSection('dashboard-section')"></a>
            
              <?php                 
                $stmt = $conn->prepare("SELECT COUNT(*) FROM diecast_model WHERE seller_id = ?");
                $stmt->bind_param("s", $_SESSION["seller_id"]);
                $stmt->execute();
                
                $result = $stmt->get_result();
                $count = $result->fetch_row()[0]; 
                
                $stmt->close();
              ?> 
              <h1><?php echo $count; ?></h1>

            <a href="#" onclick="showSection('view-product-section')">
                      <h3>View Products</h3>
            </a>
            </div>

        </div>

        <div class="all_bidding">

            <h2>All bidding</h2>
            <div class="form">
            <a href="#" class="logo" onclick="showSection('dashboard-section')"></a>
              <?php                 
                $stmt = $conn->prepare("SELECT COUNT(*) FROM bid_room WHERE seller_id = ?");
                $stmt->bind_param("s", $_SESSION["seller_id"]);
                $stmt->execute();
                
                $result = $stmt->get_result();
                $count = $result->fetch_row()[0]; 
                
                $stmt->close();
              ?> 
              <h1><?php echo $count; ?></h1>
             <a href="#" onclick="showSection('auction-section')">
                <h3>View Bidding</h3>
              </a>
            </div>
        </div>

        <div class="all_messages">
            <h2>Recent Messages</h2>
              <div>
                <div class="chat-list" id="chat-list">
                </div>

              </div>
        </div>


      </div>

    </div>


    <div id="user-profile-section" class="section">
      <div id="settings-container" class="settings-container">

      <div id="user-settings-section">
        <h2>User Settings</h2>
        <ul>
          <li><a href="#" onclick="showUserInfo()">User Info</a></li>
          <li><a href="#">Account Settings</a></li>
          <li><a href="#">Privacy</a></li>
          <li><a href="#">Logout</a></li>
        </ul>
      </div>
        
    
      <div id="user-info">
       <div class="container">
        
      <h1>User Profile</h1>
      <form id="profileForm" method="post" action="">
        <div class="form-group">
          <label for="fullname">Full Name:</label>
          <input type="text" id="fullname" name="fullname" value="<?php echo $fullname; ?>" required>
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
        </div>
        <div class="form-group">
          <label for="phone">Phone Number:</label>
          <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>" required>
        </div>
        <div class="form-group">
          <label for="address">Address:</label>
          <input type="text" id="address" name="address" value="<?php echo $address; ?>" required>
        </div>
        <div class="form-group">
          <label for="gender">Gender:</label>
          <select id="gender" name="gender" required>
            <option value="" <?php echo ($gender == "") ? "selected" : ""; ?>>Select...</option>
            <option value="male" <?php echo ($gender == "male") ? "selected" : ""; ?>>Male</option>
            <option value="female" <?php echo ($gender == "female") ? "selected" : ""; ?>>Female</option>
            <option value="other" <?php echo ($gender == "other") ? "selected" : ""; ?>>Other</option>
          </select>
        </div>
        <button type="submit">Save Changes</button>
      </form>

      <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <div class="profile-data">
          <h2>Your Profile Data</h2>
          <p><strong>Full Name:</strong> <?php echo $fullname; ?></p>
          <p><strong>Email:</strong> <?php echo $email; ?></p>
          <p><strong>Phone Number:</strong> <?php echo $phone; ?></p>
          <p><strong>Address:</strong> <?php echo $address; ?></p>
          <p><strong>Gender:</strong> <?php echo $gender; ?></p>
        </div>
      <?php endif; ?>
      
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>

    <!--view  productSection -->
   
    <div id="view-product-section" class="section">
      <h2>Product Details</h2>
    

     <div class="all-products">

     <?php
        $stmt = $conn->prepare("SELECT diecast_brand.*, diecast_size.*, diecast_model.* 
            FROM diecast_model 
            LEFT JOIN diecast_brand ON diecast_brand.brand_id = diecast_model.brand_id
            LEFT JOIN diecast_size ON diecast_size.size_id = diecast_model.size_id
            WHERE diecast_model.seller_id = ?");
        $stmt->bind_param("s", $_SESSION["seller_id"]);
        $stmt->execute();

        $result = $stmt->get_result();
      
        if ($result->num_rows > 0) {          
            while ($row = $result->fetch_assoc()) {
                $modelId = $row['model_id'];
                $sellerId = $row['seller_id'];
                $modelName = htmlspecialchars($row['model_name']);
                $modelDescription = htmlspecialchars($row['model_description']);
                $modelPrice = htmlspecialchars($row['model_price']);
                $modelStock = htmlspecialchars($row['model_stock']);
                $modelImageUrl = htmlspecialchars($row['model_image_url']);
                $brandName = htmlspecialchars($row['brand_name']);
                $sizeName = htmlspecialchars($row['ratio']);
                              
                echo '<div class="product-card">';
                                
                echo '<div class="product-image">';
                echo '<img src="http://localhost:3000/backend/' . $modelImageUrl . '" alt="' . $modelName . '">';
                echo '</div>';
                
                echo '<div class="product-info">';
                echo '<h3>' . $modelName . '</h3>';
                echo '<p class="product-description">' . $modelDescription . '</p>';
                echo '<p class="product-price"><b>Price:</b> $' . $modelPrice . '</p>';
                echo '<p class="product-stock"><b>In Stock:</b> ' . ($modelStock > 0 ? 'Yes' : 'No') . '</p>';
                echo '<p class="product-brand"><b>Brand:</b> ' . $brandName . '</p>';
                echo '<p class="product-size"><b>Size:</b> ' . $sizeName . '</p>';
                
                echo '<div class="product-actions">';
                echo '<button onclick="openEditForm(' . $modelId . ', \'' . addslashes($modelName) . '\', \'' . addslashes($modelDescription) . '\', ' . $modelPrice . ', \'' . ($modelStock > 0 ? 'Yes' : 'No') . '\')">Edit</button>';
                echo '<button onclick="deleteProduct(' . $modelId . ', ' . $sellerId . ')">Delete</button>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No products found for this seller.</p>';
        }

        $stmt->close();
      ?>

      

       <div class="product-card">
                
        <!-- Edit Product Form -->
        <div class="edit-product-form" id="editForm" style="display: none;">
          <h3>Edit Product</h3>
          <form onsubmit="submitEditForm(event)">
            <label for="edit-name">Product Name</label>
            <input type="hidden" id="seller-id" value=<?php echo $_SESSION["seller_id"] ?>>
            <input type="hidden" id="edit-model-id" name="modelId">

            <input type="text" id="edit-name" name="name">

            <label for="edit-description">Description</label>
            <textarea id="edit-description" name="description"></textarea>

            <label for="edit-price">Price</label>
            <input type="number" id="edit-price" name="price">

            <label for="edit-stock">In Stock</label>
            <select id="edit-stock" name="stock">
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>

            <div class="form-actions">
              <button type="submit">Save</button>
              <button type="button" onclick="closeEditForm()">Cancel</button>
            </div>
          </form>
        </div>

      </div>
      </div>
    </div>
   
    <!-- Add Product Section -->
    <div id="add-product-section" class="section">
      <h2>Add New Product</h2>
      <form action="#" method="POST" id="product-form">

        <div class="form-group-row">
          <div class="form-group">
            <input type="text" hidden id="seller-id" value=<?php echo $_SESSION["seller_id"] ?>>
            <label for="product-name">Product Name</label>
            <input
              type="text"
              id="product-name"
              name="product-name"
              placeholder="Enter product name"
              required
            />
          </div>

          <div class="form-group">
            <label for="product-price">Price</label>
            <input
              type="number"
              id="product-price"
              name="product-price"
              placeholder="Enter product price"
              required
            />
          </div>
          <div class="form-group">
            <label for="model_stock">Stock available:</label>
            <input
              type="number"
              id="model_stock"
              name="model_stock"
              placeholder="Enter number of available stock "
              required
            />
          </div>
        </div>
        
        <div class="form-group-row">
              <div class="form-group">
                <label for="auction-product-brand">Model Brand</label>
                <select id="model-brand" name="model-brand" required onchange="toggleOtherBrandInput()">
                  <?php
                    foreach ($brandData as $row) {
                      echo '<option value="' . htmlspecialchars($row['brand_id']) . '">' . htmlspecialchars($row['brand_name']) . '</option>';
                    }
                  ?>
                </select>
              </div>

                <!-- Input field for custom brand -->
                <div id="other-brand" style="display: none; margin-top: 10px;">
                  <label for="custom-brand">Enter Other Brand</label>
                  <input type="text" id="custom-brand" name="custom-brand">
                </div>
            

              <div class="form-group">
                <label for="model-type">Model Type</label>
                <select id="model-type" name="model-type" required>
                  <option value="Regular">Regular</option>
                  <option value="Premium">Premium</option>
                </select>
              </div>
        </div>

        <div class="form-group-row">
              <div class="form-group">
                <label for="model-packaging">Packaging</label>
                <select id="model-packaging" name="model-packaging" required>
                  <option value="unopened">Unopened</option>
                  <option value="original-packaging">Original Packaging</option>
                  <option value="none">None</option>
                </select>
              </div>

              <div class="form-group">
                <label for="model-scale">Scale</label>
                <select id="model-scale" name="model-scale" required>               
                <?php
                    foreach ($sizeData as $row) {
                      echo '<option value="' . htmlspecialchars($row['size_id']) . '">' . htmlspecialchars($row['ratio']) . '</option>';
                    }
                  ?>
                </select>
              </div>
            </div>
            


        <div class="form-group-row">
            <div class="form-group">
              <label>Condition</label>
              <div>
                <input
                  type="checkbox"
                  id="mint"
                  name="model-condition"
                  value="mint"
                />
                <label for="mint">Mint</label>

                <input
                  type="checkbox"
                  id="good-condition"
                  name="model-condition"
                  value="good condition"
                />
                <label for="good-condition">Good Condition</label>


                <input
                  type="checkbox"
                  id="near_mint"
                  name="model-condition"
                  value="near mint"
                />
                <label for="near_mint">Near Mint</label>

                <input
                  type="checkbox"
                  id="non-mint"
                  name="model-condition"
                  value="non mint"
                />
                <label for="non-mint">Non Mint</label>

                <input
                  type="checkbox"
                  id="played"
                  name="model-condition"
                  value="played"
                />
                <label for="played">Played</label>
              </div>
            </div>

            <div class="form-group">
              <label>Model Tags</label>
              <div>
                <input
                  type="checkbox"
                  id="limited_edition"
                  name="model-tags"
                  value="limited_edition"
                />
                <label for="limited_edition">Limited Edition</label>

                <input
                  type="checkbox"
                  id="new_arrivals"
                  name="model-tags"
                  value="new_arrivals"
                />
                <label for="new_arrivals">New Arrivals</label>

                <input
                  type="checkbox"
                  id="featured"
                  name="model-tags"
                  value="featured"
                />
                <label for="featured">Featured</label>

                <input
                  type="checkbox"
                  id="best_seller"
                  name="model-tags"
                  value="best_seller"
                />
                <label for="best_seller">Best Seller</label>
              </div>
            </div>
          </div>


        <div class="form-group">
            <label for="product-description">Description</label>
            <textarea
              id="product-description"
              name="product-description"
              rows="4"
              placeholder="Enter product description"
              required
            ></textarea>
        </div>
        <div class="form-group">
            <label for="product-image">Product Image</label>
            <input type="file" id="product-image" name="product-image" />
        </div>

          <div class="button-group">
            <button type="submit" class="btn sell-btn">Sell Product</button>
            <button type="reset" class="btn cancel-btn">Cancel</button>
          </div>
  
      </form>
    </div>

    <!-- Customer Section -->
    <div id="customers-section" class="section">
      <h2>Customers</h2>
      <ul class="customer-list" id="customer-list">
        <?php
          $stmt = $conn->prepare("SELECT 
              DISTINCT customer.customer_id,
              CONCAT(customer.first_name, ' ', customer.last_name) AS customer_name,            
              customer.address,
              customer.contact_number
          FROM 
              order_info 
          LEFT JOIN 
              order_items ON order_info.order_id = order_items.order_id
          LEFT JOIN 
              diecast_model ON diecast_model.model_id = order_items.model_id
          LEFT JOIN 
              customer ON customer.customer_id = order_info.customer_id
          WHERE 
              diecast_model.seller_id = ?
          ");
          $stmt->bind_param("s", $_SESSION["seller_id"]);
          $stmt->execute();

          $result = $stmt->get_result();

          if ($result->num_rows > 0) {          
              while ($row = $result->fetch_assoc()) {
                  echo "<li>";
                  echo "Customer ID: " . htmlspecialchars($row['customer_id']) . "<br>";
                  echo "Customer Name: " . htmlspecialchars($row['customer_name']) . "<br>";
                  echo "Address: " . htmlspecialchars($row['address']) . "<br>";
                  echo "Contact Number: " . htmlspecialchars($row['contact_number']) . "<br><br>";
                  echo "</li>";
              }
          } else {
              echo "No customers found.";
          }

          $stmt->close();
        ?>

      </ul>
    </div>

    <!-- Orders Section -->
    <div id="orders-section" class="section">
      <h2>Orders</h2>
      <table>
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Product</th>
            <th>Status</th>
            <th>Tracking Number</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php
          $stmt = $conn->prepare("
              SELECT 
                  order_info.order_id,
                  order_info.order_ref_no,
                  order_info.order_status,
                  order_info.order_trackingnum,
                  customer.customer_id,
                  CONCAT(customer.first_name, ' ', customer.last_name) AS customer_name,
                  GROUP_CONCAT(diecast_model.model_name SEPARATOR ', ') AS model_names  -- Concatenate model names
              FROM 
                  order_info 
              LEFT JOIN 
                  order_items ON order_info.order_id = order_items.order_id
              LEFT JOIN 
                  diecast_model ON diecast_model.model_id = order_items.model_id
              LEFT JOIN 
                  customer ON customer.customer_id = order_info.customer_id
              WHERE 
                  diecast_model.seller_id = ?
              GROUP BY 
                  order_info.order_id, order_info.order_ref_no, order_info.order_status, customer.customer_id
          ");

          $stmt->bind_param("s", $_SESSION["seller_id"]);
          $stmt->execute();
          $result = $stmt->get_result();

          if ($result->num_rows > 0) {          
              while ($row = $result->fetch_assoc()) {
                  $refNo = htmlspecialchars($row['order_ref_no']);
                  echo '<tr>
                    <td>' . $refNo . '</td>
                    <td>' . htmlspecialchars($row['customer_name']) . '</td>
                    <td>' . htmlspecialchars($row['model_names']) . '</td>
                    <td>
                        <select class="order-status" id="order-status-' . htmlspecialchars($row['order_id']) . '">
                            <option value="">Select a status</option>
                            <option value="Order Placed"' . ($row['order_status'] === 'Order Placed' ? ' selected' : '') . '>Order Placed</option>
                            <option value="Waiting for courier"' . ($row['order_status'] === 'Waiting for courier' ? ' selected' : '') . '>Waiting for courier</option>
                            <option value="In Transit"' . ($row['order_status'] === 'In Transit' ? ' selected' : '') . '>In Transit</option>
                            <option value="Delivered"' . ($row['order_status'] === 'Delivered' ? ' selected' : '') . '>Delivered</option>
                        </select>
                    </td>
                    <td>
                        <input 
                            type="text" 
                            class="tracking-number" 
                            id="order-tracking-num-' . htmlspecialchars($row['order_id']) . '" 
                            placeholder="Enter tracking number" 
                            value="' . (!empty($row['order_trackingnum']) ? htmlspecialchars($row['order_trackingnum']) : '') . '" 
                        />
                    </td>
                    <td>
                        <button
                            type="button" 
                            class="update-btn" 
                            onclick="updateOrder(' . htmlspecialchars($row['order_id']) . ', \'' . addslashes($refNo) . '\', \'' . addslashes($row['order_status']) . '\')"
                        >
                            Update
                        </button>
                    </td>
                  </tr>';

              }
          } else {
              echo "<tr><td colspan='6'>No orders found.</td></tr>";
          }

          $stmt->close();
          ?>


                    
        </tbody>
      </table>
    </div>

     <!-- Auction Section -->
    <div id="auction-section" class="section">
      <h2>Auction</h2>
      
      <div class="ongoing-bids">

        <!-- Ongoing Auction  -->
        <h3>Ongoing Bids</h3>


        <div class="auction-list" id="ongoing-bids-list">
          <?php
            $stmt = $conn->prepare("
                SELECT 
                    bid_room.bidding_id,
                    bid_room.seller_id,
                    bid_room.model_id,
                    bid_room.details,
                    bid_room.start_amount,
                    bid_room.end_amount,
                    bid_room.bid_status,
                    bid_room.start_time,
                    bid_room.end_time,
                    diecast_size.ratio,
                    diecast_brand.brand_name,
                    diecast_model.model_name,
                    diecast_model.model_description,
                    diecast_model.model_tags,
                    diecast_model.model_type,
                    diecast_model.model_image_url                    
                FROM 
                    bid_room
                LEFT JOIN 
                    diecast_model ON diecast_model.model_id = bid_room.model_id
                LEFT JOIN 
                    diecast_size ON diecast_size.size_id = diecast_model.size_id
                LEFT JOIN 
                    diecast_brand ON diecast_brand.brand_id = diecast_model.brand_id
                WHERE 
                    bid_room.seller_id = ?
            ");
            
           
            $stmt->bind_param("s", $_SESSION["seller_id"]);
            $stmt->execute();
            $result = $stmt->get_result();

           
            if ($result->num_rows > 0) {
               
                while ($row = $result->fetch_assoc()) {
                   
                    $highestBid = $row['end_amount'] ?? $row['start_amount'];
                   
                    $currentDateTime = new DateTime();
                    $endDateTime = new DateTime($row['end_time']);
                    $status = "Closed";
                    if ($row["bid_status"] !== "Closed") {
                      $status = ($currentDateTime < $endDateTime) ? "Active" : "Ended";
                    }
                    

                   
                    echo '<div class="bid-card">';
                    echo '<strong>Product:</strong> ' . htmlspecialchars($row['model_name']) . '<br />';
                    echo '<strong>Highest Bid:</strong> $' . htmlspecialchars($highestBid) . '<br />';
                    echo '<strong>Status:</strong> ' . $status . '<br />';
                    echo '<strong>Start Time:</strong> ' . date("Y-m-d h:i A", strtotime($row['start_time'])) . '<br />';
                    echo '<strong>End Time:</strong> ' . date("Y-m-d h:i A", strtotime($row['end_time'])) . '<br />';

                    if ($status !== "Closed") {
                      echo '<div class="auction-actions">';
                      echo '<button class="btn cancel-btn" onclick="cancelBid(' . htmlspecialchars($row['bidding_id']) . ')">Cancel Bid</button>';
                      echo '</div>';
                    }
                    

                    echo '</div>';
                }
            } else {
                echo "You don't have posted a bid yet. You can post a bid by clicking the 'Add New Bid'.";
            }

           
            $stmt->close();
          ?>

        </div>

      </div>

      <div class="add-bid">
        <h3>Add New Bid <span class="plus-icon" onclick="toggleBidForm()">+</span></h3>
      </div>

      <!-- Add Auction Bid Form -->
      <div id="add-bid-form"  class="form" style="display: none;">
        <form action="#" method="POST" id="auction-form">
         
          <div class="form-group">
            <input type="hidden" id="seller-id" value=<?php echo $_SESSION["seller_id"] ?>>

            <label for="auction-product-name">Product Name</label>
            <input
              type="text"
              id="auction-product-name"
              name="auction-product-name"
              placeholder="Enter product name"
              required
            />
          </div>

          <div class="form-group">
            <label for="auction-details">Details</label>
            <input
              type="text"
              id="auction-details"
              name="auction-details"
              placeholder="Enter product details"
              required
            />
          </div>
          
          <div class="form-group-row">
            <div class="form-group">
              <label for="auction-product-brand">Model Brand</label>
              <select id="model-brand" name="model-brand" required onchange="toggleOtherBrandInput()">
                <?php
                  foreach ($brandData as $row) {
                    echo '<option value="' . htmlspecialchars($row['brand_id']) . '">' . htmlspecialchars($row['brand_name']) . '</option>';
                  }
                ?>
              </select>
            </div>

              <!-- Input field for custom brand -->
              <div id="other-brand" style="display: none; margin-top: 10px;">
                <label for="custom-brand">Enter Other Brand</label>
                <input type="text" id="custom-brand" name="custom-brand">
              </div>
           

            <div class="form-group">
              <label for="model-type">Model Type</label>
              <select id="model-type" name="model-type" required>
                <option value="physical">Regular</option>
                <option value="digital">Premium</option>
              </select>
            </div>
          </div>


          <div class="form-group-row">
            <div class="form-group">
              <label for="model-packaging">Packaging</label>
              <select id="model-packaging" name="model-packaging" required>
                <option value="unopened">Unopened</option>
                <option value="original-packaging">Original Packaging</option>
                <option value="none">None</option>
              </select>
            </div>

            <div class="form-group">
              <label for="model-scale">Scale</label>
              <select id="model-scale" name="model-scale" required>
                <?php
                    foreach ($sizeData as $row) {
                      echo '<option value="' . htmlspecialchars($row['size_id']) . '">' . htmlspecialchars($row['ratio']) . '</option>';
                    }
                  ?>
              </select>
            </div>
          </div>
          

        <div class="form-group-row">
          <div class="form-group">
            <label>Condition</label>
            <div>
              <input
                type="checkbox"
                id="mint"
                name="model-condition"
                value="mint"
              />
              <label for="mint">Mint</label>

              <input
                type="checkbox"
                id="good-condition"
                name="model-condition"
                value="good condition"
              />
              <label for="good-condition">Good Condition</label>


              <input
                type="checkbox"
                id="near_mint"
                name="model-condition"
                value="near mint"
              />
              <label for="near_mint">Near Mint</label>

              <input
                type="checkbox"
                id="non-mint"
                name="model-condition"
                value="non mint"
              />
              <label for="non-mint">Non Mint</label>

              <input
                type="checkbox"
                id="played"
                name="model-condition"
                value="played"
              />
              <label for="played">Played</label>
            </div>
          </div>

          <div class="form-group">
            <label>Model Tags</label>
            <div>
              <input
                type="checkbox"
                id="limited_edition"
                name="model-tags"
                value="limited_edition"
              />
              <label for="limited_edition">Limited Edition</label>

              <input
                type="checkbox"
                id="new_arrivals"
                name="model-tags"
                value="new_arrivals"
              />
              <label for="new_arrivals">New Arrivals</label>

              <input
                type="checkbox"
                id="featured"
                name="model-tags"
                value="featured"
              />
              <label for="featured">Featured</label>

              <input
                type="checkbox"
                id="best_seller"
                name="model-tags"
                value="best_seller"
              />
              <label for="best_seller">Best Seller</label>
            </div>
          </div>
        </div>


          <div class="form-group">
            <label for="product-bid-image">Product Image</label>
            <input type="file" id="product-bid-image" name="product-bid-image" />
          </div>

          <div class="form-group">
              <label for="starting-bid">Starting Bid (₱)</label>
              <input
                type="number"
                id="starting-bid"
                name="starting-bid"
                placeholder="Enter starting bid"
                required
              />
            </div>

            <div class="form-group-row">
              <div class="form-group">
                <label for="auction-start-date">Start Date</label>
                <input type="date" id="auction-start-date" name="auction-start-date" required />
              </div>

              <div class="form-group">
                <label for="auction-end-date">End Date</label>
                <input type="date" id="auction-end-date" name="auction-end-date" required />
              </div>
            </div>


            <div class="button-group">
              <button type="submit" class="btn sell-btn">Add Bid</button>
              <button type="reset" class="btn cancel-btn">Cancel</button>
            </div>
          </div>




        </form>
        </div>
      </div>
      
      
    </div>

      <!-- Messages Section -->
      <div id="message-section" class="section">

        <div class="chat-container">

          <!-- Left Chat List -->
          <div class="chat-list" id="chat-list1">                      
          </div>

          <!-- Right Chat Box -->
        <div class="chat-box" id="chat-box">
            <div class="messages" id="messages">             
            </div>
            
            <form id="message-form">
              <div class="message-input">
                <input type="hidden" id="room-id" value="">
                <input type="hidden" id="seller-id" value="<?php echo $_SESSION["seller_id"]?>">
                <input type="hidden" id="user-type" value="<?php echo $_SESSION["user_type"]?>">

                <input type="text" id="message-input" placeholder="Type your message here..." />
                                  
                <input type="file" id="image-input" accept="image/*" style="display: none;" />
                                  
                <span class="material-symbols-outlined" id="file-icon" onclick="document.getElementById('image-input').click();">
                    attach_file
                </span>

                <button type="button" onclick="sendMessage()">Send</button>
              </div>
            </form>
          </div>
        </div>

      </div>

    <script>

/*
    function showUserInfo() {
      document.getElementById('user-info-section').style.display = 'block';
    }

    function editUserInfo() {
      document.getElementById('username').readOnly = false;
      document.getElementById('email').readOnly = false;
      document.getElementById('phone').readOnly = false;
      document.getElementById('address').readOnly = false;
    }

    function saveUserInfo() {
      document.getElementById('username').readOnly = true;
      document.getElementById('email').readOnly = true;
      document.getElementById('phone').readOnly = true;
      document.getElementById('address').readOnly = true;
      alert("User information saved successfully!");
    }

    function goBackToSettings() {
      document.getElementById('user-info-section').style.display = 'none';
    }
    */
    </script>

    <script>

      function toggleDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        const arrow = dropdown.previousElementSibling.querySelector('.dropdown-arrow');
        dropdown.classList.toggle('show'); 
        arrow.classList.toggle('rotate');

         // Calculate the dropdown height for smooth transition
          if (dropdown.classList.contains('show')) {
              dropdown.style.maxHeight = dropdown.scrollHeight + "px"; // Set maxHeight to its scrollHeight when shown
          } else {
              dropdown.style.maxHeight = "0"; // Reset maxHeight to 0 when hidden
          }
      }

    

    function showSection(sectionId) {
        try {
            // Hide all sections first
            const sections = document.querySelectorAll('.section');
            sections.forEach(section => section.classList.remove('active'));

            // Show the selected section based on the ID
            const selectedSection = document.getElementById(sectionId);
            if (selectedSection) {
                selectedSection.classList.add('active');
                localStorage.setItem('activeSection', sectionId); // Save the active section in localStorage
            } else {
                console.error(`Section with ID '${sectionId}' not found.`);
            }
        } catch (error) {
            console.error('Error showing section:', error);
        }
    }

      // Function to load the last active section on page load
      window.addEventListener('DOMContentLoaded', () => {
          try {
              // Retrieve the last active section from localStorage, default to 'dashboard' if none found
              const savedSection = localStorage.getItem('activeSection') || 'dashboard';
              
              // Verify the section exists before displaying
              const sectionExists = document.getElementById(savedSection);
              if (sectionExists) {
                  showSection(savedSection);
                  console.log(`Loaded section from storage: ${savedSection}`);
              } else {
                  console.warn(`Saved section '${savedSection}' not found. Loading default section.`);
                  showSection('dashboard');
              }
          } catch (error) {
              console.error('Error loading saved section:', error);
              showSection('dashboard'); // Default to dashboard on error
          }
      });

      function hideDash(){
        const dash = document.querySelectorAll(".dash");
        

        dash.classList.remove("visible");
        dash.forEach((dashElement) => dashElement.classList.remove("visible"));

        

      }


      const sidebar = document.querySelector(".sidebar");
      const menuBtn = document.querySelector(".menubtn");

      function showSidebar() {
        sidebar.style.display = "flex"; // Show the sidebar
        document.addEventListener("click", handleOutsideClick); // Attach the click listener
      }

      function hideSidebar() {
        sidebar.style.display = "none"; // Hide the sidebar
        document.removeEventListener("click", handleOutsideClick); // Remove the listener
      }

      function handleOutsideClick(event) {
        const isClickInsideSidebar = sidebar.contains(event.target);
        const isClickOnMenuBtn = menuBtn.contains(event.target);

        if (!isClickInsideSidebar && !isClickOnMenuBtn) {
          hideSidebar(); // Hide sidebar if the click is outside both sidebar and menu button
        }
      }

      // Attach event listeners
      menuBtn.addEventListener("click", (event) => {
        event.stopPropagation(); // Prevent the click from closing the sidebar immediately
        showSidebar();
      });

      async function submitEditForm(event) {
        event.preventDefault();

        const sellerId = document.getElementById('seller-id').value;
        const modelId = document.getElementById('edit-model-id').value;
        const name = document.getElementById('edit-name').value;
        const description = document.getElementById('edit-description').value;
        const price = document.getElementById('edit-price').value;
        const stock = document.getElementById('edit-stock').value;
        
        const formData = new URLSearchParams({
          seller_id: sellerId,
          model_id: modelId,
          model_name: name,
          model_description: description,
          model_price: price,
          model_availability: stock === "Yes" ? "Available" : "Out of stock"
        });
        
        try {
        const response = await fetch('/backend/src/seller/route.php?route=seller/edit/product', {
              method: 'POST', 
              body: formData 
          });          
          if (!response.ok) {
              throw new Error(`HTTP error! Status: ${response.status}`);
          }          
          const responseData = await response.json();
                                      
          alert('product edited')
          closeEditForm();
          window.location.reload()
        } catch (error) {
            console.error('Error during fetch:', error);
        }
      }


      function openEditForm(modelId, name, description, price, stock) {
        
        document.getElementById('edit-name').value = name;
        document.getElementById('edit-description').value = description;
        document.getElementById('edit-price').value = price;
        document.getElementById('edit-stock').value = stock;                
        document.getElementById('edit-model-id').value = modelId
        
        document.getElementById('editForm').style.display = 'block';
      }


      function closeEditForm() {
        document.getElementById('editForm').style.display = 'none';
      }


      function toggleBidForm() {
          const form = document.getElementById("add-bid-form");
          form.style.display = form.style.display === "none" ? "block" : "none";
        }

        function addNewBid() {
          // Example function to handle adding the bid
          const product = document.getElementById("product").value;
          const bid = document.getElementById("bid").value;

          if (product && bid) {
            // Add bid logic here
            alert(`New bid added for ${product} with starting bid $${bid}`);
            toggleBidForm(); // Hide the form after submission
          } else {
            alert("Please fill out all fields.");
          }
        }

      
    </script>

    <script>

      document.getElementById('product-form').addEventListener('submit', function (event) {
        event.preventDefault(); 

        const sellerId = document.getElementById("seller-id").value
        const productName = document.getElementById('product-name').value;
        const productBrand = document.getElementById('model-brand').value;
        const productSize = document.getElementById('model-scale').value;
        const productType = document.getElementById('model-type').value;
        const productPrice = document.getElementById('product-price').value;
        const modelStock = document.getElementById('model_stock').value;
        const modelType = document.getElementById('model-type').value;
        const description = document.getElementById('product-description').value;
        const fileInput = document.querySelector('input[type="file"]'); 

        const productPackaging = document.getElementById('model-packaging').value;

        const packageConditions = Array.from(document.querySelectorAll('input[name="model-condition"]:checked'))
            .map(checkbox => checkbox.value.replace(/_/g, ' '))
            .map(condition => condition.split(' ')
              .map(word => word.charAt(0).toUpperCase() + word.slice(1))
              .join(' ')
            );

        const tags = Array.from(document.querySelectorAll('input[name="model-tags"]:checked'))
        .map(checkbox => checkbox.value.replace(/_/g, ' '))
        .map(tag => tag.split(' ')
          .map(word => word.charAt(0).toUpperCase() + word.slice(1))
          .join(' ')
        );
      
        const formData = new FormData();
                        
        formData.append('seller_id', sellerId);
        formData.append('size_id', productSize);
        formData.append('brand_id', productBrand);
        formData.append('model_name', productName);
        formData.append('model_description', description);
        formData.append('model_price', productPrice);
        formData.append('model_stock', modelStock);
        formData.append('model_availability', 'Available');
        formData.append('model_tags', tags.length ? tags.join(', ') : '');
        formData.append('model_type', productType);
        formData.append('model_packaging', productPackaging);
        formData.append('model_condition', packageConditions);
                             
        if (fileInput.files.length > 0) {
            formData.append('model_image', fileInput.files[0]); 
        } else {
            console.error('No file selected for upload');
            return; 
        }
        addProductWithFile()

        async function addProductWithFile() {
          try {
            const response = await fetch('/backend/src/seller/route.php?route=seller/add/product', {
                method: 'POST', 
                body: formData 
            });          
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }          
            const responseData = await response.json();
                        
            alert(responseData.message)
          } catch (error) {
              console.error('Error during fetch:', error);
          }
        }
      });

      document.getElementById('auction-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission for testing display

        const sellerId = document.getElementById('seller-id').value
        const productName = document.getElementById('auction-product-name').value;
        const productDetails = document.getElementById('auction-details').value;
        const productBrand = document.getElementById('model-brand').value;
        const productSize = document.getElementById('model-scale').value;
        const productType = document.getElementById('model-type').value;
        const productPrice = document.getElementById('product-price').value;        
        const bidStartAmount = document.getElementById('starting-bid').value;
        const bidStartDate = document.getElementById('auction-start-date').value;
        const bidEndDate = document.getElementById('auction-end-date').value;
        const fileInput = document.getElementById('product-bid-image').files[0];
        
        const productPackaging = document.getElementById('model-packaging').value;
        
        const packageConditions = Array.from(document.querySelectorAll('input[name="model-condition"]:checked'))
            .map(checkbox => checkbox.value.replace(/_/g, ' '))
            .map(condition => condition.split(' ')
              .map(word => word.charAt(0).toUpperCase() + word.slice(1))
              .join(' ')
            );

        const tags = Array.from(document.querySelectorAll('input[name="model-tags"]:checked'))
        .map(checkbox => checkbox.value.replace(/_/g, ' '))
        .map(tag => tag.split(' ')
          .map(word => word.charAt(0).toUpperCase() + word.slice(1))
          .join(' ')
        );
      
        const formData = new FormData();
                        
        formData.append('seller_id', sellerId);
        formData.append('size_id', productSize);
        formData.append('brand_id', productBrand);
        formData.append('model_name', productName);
        formData.append('model_description', "Empty Description");
        formData.append('model_price', bidStartAmount);
        formData.append('model_stock', 1);
        formData.append('model_availability', 'Available');
        formData.append('model_tags', tags.length ? tags.join(', ') : '');
        formData.append('model_type', productType);
        formData.append('model_packaging', productPackaging);
        formData.append('model_condition', packageConditions);
        formData.append('details', productDetails);
        formData.append('start_amount', bidStartAmount);
        formData.append('start_time', bidStartDate);
        formData.append('end_time', bidEndDate);
                             
        if (fileInput) {
            formData.append('model_image', fileInput); 
        } else {
            console.error('No file selected for upload');
            return; 
        }
        
        postBitItem()

        async function postBitItem() {
          try {
            const response = await fetch('/backend/src/seller/route.php?route=seller/post/bid', {
                method: 'POST', 
                body: formData 
            });          
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }          
            const responseData = await response.json();
                                  
            alert(responseData.message)
          } catch (error) {
              console.error('Error during fetch:', error);
          }
        }
        
      });

    </script>

    <script>
      const messagesData = {};
      const sellerId = document.getElementById("seller-id").value;
      fetch(`/backend/src/chat/route.php?route=last/chat/get&seller_id=${sellerId}`, {
        method: 'GET',                
        headers: {
            'Content-Type': 'application/json'
        }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(chat => {            
            const chatListDiv = document.getElementById("chat-list");
            const chatListDiv1 = document.getElementById("chat-list1");
            chatListDiv.innerHTML = ""; 
            chatListDiv1.innerHTML = ""; 

            const title = document.createElement("h2");
            title.innerHTML = `Chat List`
            chatListDiv1.appendChild(title); 
            
                        
            chat.data.forEach(chat => {                            
                const chatItem = document.createElement("div");
                chatItem.className = "chat-list-item";
                chatItem.onclick = () => openChat(chat.room_id);                 
                chatItem.innerHTML = `
                    ${chat.seller_name} - <small>Last message: ${chat.message}</small>
                `;

                const chatItem1 = document.createElement("div");
                chatItem1.className = "chat-list-item";
                chatItem1.onclick = () => openChat(chat.room_id);                 
                chatItem1.innerHTML = `
                    ${chat.seller_name} - <small>Last message: ${chat.message}</small>
                `;
                
                chatListDiv.appendChild(chatItem);                 
                chatListDiv1.appendChild(chatItem1);                
            });
                        
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });

    </script>
   
    <script>

      async function sendMessage() {
        event.preventDefault()
        
        const roomId = document.getElementById("room-id").value
        const senderId = document.getElementById("seller-id").value
        const userType = document.getElementById("user-type").value
        const message = document.getElementById('message-input').value;
                
        const file = document.getElementById('image-input').files[0];        
        
        const data = new URLSearchParams({          
          room_id: roomId,
          sender_id: senderId,
          user_type: userType,
          message: message,
          attachment: file ? file : null,
        });

        const formData = new FormData();
                        
        formData.append('room_id', roomId);
        formData.append('sender_id', senderId);
        formData.append('user_type', userType);
        formData.append('message', message);
        formData.append('attachment', file);
       
        fetch('/backend/src/chat/route.php?route=chat/send', {
          method: 'POST',
          body: formData,          
          })
          .then(response => {
              if (!response.ok) {
                  throw new Error('Network response was not ok');
              }
              return response.json();
          })
          .then(data => {
              console.log(data);              
              alert("message sent")
              document.getElementById('message-form').reset();
          })
          .catch(error => {
              console.error('There was a problem with the fetch operation:', error);
          });

        

      }

      async function cancelBid(biddingId) {
        
        const data = new URLSearchParams({
          bidding_id: biddingId
        });
        try {
          const response = await fetch('/backend/src/seller/route.php?route=seller/cancel/bid', {
              method: 'POST', 
              body: data 
          });          
          if (!response.ok) {
              throw new Error(`HTTP error! Status: ${response.status}`);
          }          
          const responseData = await response.json();
                                              
          alert('bid item cancelled')
          window.location.reload();
        } catch (error) {
            console.error('Error during fetch:', error);
        }
      }

      async function updateOrder(orderId, refNo, status) {
                
        const newStatus = document.getElementById(`order-status-${orderId}`).value
        const trackingNumber = document.getElementById(`order-tracking-num-${orderId}`).value
        if (status === newStatus || newStatus === "")  {         
          return
        }
            
        const data = new URLSearchParams({                
          order_id: orderId,
          order_ref_no: refNo,
          order_status: newStatus,
          order_trackingnum: trackingNumber
        });
        try {
          const response = await fetch('/backend/src/seller/route.php?route=seller/update/status/order', {
              method: 'POST', 
              body: data 
          });          
          if (!response.ok) {
              throw new Error(`HTTP error! Status: ${response.status}`);
          }          
          const responseData = await response.json();
                                              
          alert(responseData.message)
          window.location.reload();
        } catch (error) {
            console.error('Error during fetch:', error);
        }
      }

      async function deleteProduct(modelId, sellerid) {        
          const data = new URLSearchParams({                
            model_id: modelId,
            seller_id: sellerId
          });
          try {
            const response = await fetch('/backend/src/seller/route.php?route=seller/delete/product', {
                method: 'POST', 
                body: data 
            });          
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }          
            const responseData = await response.json();
                                                
            alert('product deleted')
            window.location.reload();
          } catch (error) {
              console.error('Error during fetch:', error);
          }
        
      }
            
      function openChat(chatId) {
        const chatBox = document.getElementById('messages');
        chatBox.innerHTML = ''; // Clear previous messages      
        
        fetch(`/backend/src/chat/route.php?route=chat/get&room_id=${chatId}&limit=10&offset=0`, {
          method: 'GET',                
          headers: {
              'Content-Type': 'application/json'
          }
          })
          .then(response => {
              if (!response.ok) {
                  throw new Error('Network response was not ok');
              }
              return response.json();
          })
          .then(chat => {
            
            chat.data.forEach(chat => {    
                        
              if (!messagesData[chatId]) {
                  messagesData[chatId] = [];
              }                                
              const messageExists = messagesData[chatId].some(message => message.id === chat.message_id);
              if (!messageExists) {
                messagesData[chatId].push({ id: chat.message_id, type: chat.sender_type, sender: chat.name, text: chat.message });
              }
            })
            const chatMessages = messagesData[chatId];      
              
            
            const roomId = document.getElementById("room-id");
            roomId.value = chatId;

            chatMessages.forEach((message) => {
              const messageElement = document.createElement('div');
                                          
              messageElement.classList.add('message');
              
              if (message.type === "seller") {
                messageElement.innerHTML = ` <div class="message sent"> <strong>${message.sender}:</strong> ${message.text} </div>`;               
              } else {                               
                messageElement.innerHTML = ` <div class="message received"> <strong>${message.sender}:</strong> ${message.text} </div>`;
              }            
              chatBox.appendChild(messageElement);
            });
          })
          .catch(error => {
              console.error('There was a problem with the fetch operation:', error);
          });                  
      }

 

    </script>
  </body>
</html>