
<?php


// session_start()


$_SESSION["seller_id"] = 12;



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
              <p><b>Ivan Garcia</b></p>
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
                <h1> 2 </h1>
                <a href="#" onclick="showSection('view-product-section')">
                          <h3>View Products</h3>
                </a>
              </div>
          </div>

          <div class="all_bidding">
              <h2>All bidding</h2>
              <div class="form">
                <a href="#" class="logo" onclick="showSection('dashboard-section')"></a>
              <h1> 2 </h1>
                <a href="#" onclick="showSection('auction-section')">
                  <h3>View Bidding</h3>
                </a>
              </div>
          </div>

          <div class="all_messages">
              <h2>Recent Messages</h2>
                <div>
                  <div class="chat-list" id="chat-list">
                    <div class="chat-list-item" onclick="openChat(1)">
                      John Doe - <small>Last message: Hi, I have a question...</small>
                    </div>
                    <div class="chat-list-item" onclick="openChat(2)">
                      Jane Smith - <small>Last message: Thanks for the delivery!</small>
                    </div>

                    <div class="chat-list-item" onclick="openChat(3)">
                      Baxter Sisgado - <small>Last message: Mine po..</small>
                    </div>
                  </div>
                </div>
          </div>
    </div>


      
    <!-- For User Profile Section -->

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


    <!--view  productSection -->
    <div id="view-product-section" class="section">
      <h2>Product Details</h2>
    

     <div class="all-products">
      <div class="product-card">
          <!-- Product Image -->
          <div class="product-image">
              <img src="assets/P1.png" alt="Product Image">
          </div>

        <!-- Product Information -->
          <div class="product-info">
              <h3>Product Name</h3>
              <p class="product-description">This is a detailed description of the product. It provides key features and insights about the product for potential buyers.</p>
              <p class="product-price"><b>Price:</b> $29.99</p>
              <p class="product-stock"><b>In Stock:</b> Yes</p>
            
            <!-- Product Actions -->
          <div class="product-actions">
            <button onclick="openEditForm()">Edit</button>
            <button onclick="deleteProduct()">Delete</button>
          </div>
      </div>
      </div>
      

       <div class="product-card">
        <!-- Product Image -->
        <div class="product-image">
            <img src="assets/P1.png" alt="Product Image">
        </div>

        

        <!-- Product Information -->
        <div class="product-info">
          <h3>Product Name</h3>
          <p class="product-description">
            This is a detailed description of the product. It provides key features and insights about the product for potential buyers.
          </p>
          <p class="product-price"><b>Price:</b> $29.99</p>
          <p class="product-stock"><b>In Stock:</b> Yes</p>

          <!-- Product Actions -->
          <div class="product-actions">
            <button onclick="openEditForm()">Edit</button>
            <button onclick="deleteProduct()">Delete</button>
          </div>
        </div>

        <!-- Edit Product Form -->
        <div class="edit-product-form" id="editForm" style="display: none;">
          <h3>Edit Product</h3>
          <form onsubmit="submitEditForm(event)">
            <label for="edit-name">Product Name</label>
            <input type="text" id="edit-name" name="name" value="Product Name">

            <label for="edit-description">Description</label>
            <textarea id="edit-description" name="description">This is a detailed description of the product.</textarea>

            <label for="edit-price">Price</label>
            <input type="number" id="edit-price" name="price" value="29.99">

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
                <option value="auto-world">Auto World</option>
                <option value="bburago">Bburago</option>
                <option value="greenlight">Greenlight</option>
                <option value="hotwheels">Hot Wheels</option>
                <option value="jada-toys">Jada Toys</option>
                <option value="m2-machines">M2 Machines</option>
                <option value="matchbox">Matchbox</option>
                <option value="tomica">Tomica</option>
                <option value="other">Other</option>
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
                <option value="1:18">1:18</option>
                <option value="1:24">1:24</option>
                <option value="1:32">1:32</option>
                <option value="1:43">1:43</option>
                <option value="1:64">1:64</option>
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
                value="good-condition"
              />
              <label for="good-condition">Good Condition</label>


              <input
                type="checkbox"
                id="near_mint"
                name="model-condition"
                value="near_mint"
              />
              <label for="near_mint">Near Mint</label>

              <input
                type="checkbox"
                id="non-mint"
                name="model-condition"
                value="non-mint"
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
        <!-- Customer data will load here dynamically -->
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
          <tr>
            <td>#001</td>
            <td>John Doe</td>
            <td>Car Engine</td>
            <td>
              <select class="order-status" data-order-id="1">
                <option value="Order placed">Order placed</option>
                <option value="Waiting for courier">Waiting for courier</option>
                <option value="In Transit">In Transit</option>
                <option value="Order delivered">Delivered</option>
              </select>
            </td>
            <td>
              <input type="text" class="tracking-number" data-order-id="1" placeholder="Enter tracking number" />
            </td>
            <td>
              <button class="update-btn" onclick="updateOrder(1)">Update</button>
            </td>
          </tr>
          <tr>
            <td>#002</td>
            <td>Jane Smith</td>
            <td>Tire Set</td>
            <td>
              <select class="order-status" data-order-id="2">
                <option value="Order placed">Order placed</option>
                <option value="Waiting for courier">Waiting for courier</option>
                <option value="In Transit">In Transit</option>
                <option value="Order delivered">Delivered</option>
              </select>
            </td>
            <td>
              <input type="text" class="tracking-number" data-order-id="2" placeholder="Enter tracking number" />
            </td>
            <td>
              <button   class="update-btn" onclick="updateOrder(2)">Update</button>
            </td>
          </tr>
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

          <div  class="bid-card">
            <strong>Product:</strong> Car Engine
            <br />
            <strong>Highest Bid:</strong> $500
            <br />
            <strong>Status:</strong> Active
            <br />
            <strong>Start Time:</strong> 2024-10-28 10:00 AM
            <br />
            <strong>End Time:</strong> 2024-10-30 10:00 AM

            <div class="auction-actions">
              <button class="btn cancel-btn" onclick="cancelBid(1)">Cancel Bid</button>
            </div>
          </div>

          <div class="bid-card">
            <strong>Product:</strong> Car Engine
              <br />
              <strong>Highest Bid:</strong> $500
              <br />
              <strong>Status:</strong> Active
              <br />
              <strong>Start Time:</strong> 2024-10-28 10:00 AM
              <br />
              <strong>End Time:</strong> 2024-10-30 10:00 AM

              <div class="auction-actions">
                <button class="btn cancel-btn" onclick="cancelBid(1)">Cancel Bid</button>
            </div>
          </div>

        </div>

      </div>

      <div class="add-bid">
        <h3>Add New Bid <span class="plus-icon" onclick="toggleBidForm()">+</span></h3>
      </div>

      <!-- Add Auction Bid Form -->
      <div id="add-bid-form"  class="form" style="display: none;">
        <form action="#" method="POST" id="auction-form">
         
          <div class="form-group">
            <input type="text" hidden id="seller-id" value=<?php echo $_SESSION["seller_id"] ?>>

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
              id="auction-product-name"
              name="auction-product-name"
              placeholder="Enter product details"
              required
            />
          </div>
          
          <div class="form-group-row">
            <div class="form-group">
              <label for="auction-product-brand">Model Brand</label>
              <select id="model-brand" name="model-brand" required onchange="toggleOtherBrandInput()">
                <option value="auto-world">Auto World</option>
                <option value="bburago">Bburago</option>
                <option value="greenlight">Greenlight</option>
                <option value="hotwheels">Hot Wheels</option>
                <option value="jada-toys">Jada Toys</option>
                <option value="m2-machines">M2 Machines</option>
                <option value="matchbox">Matchbox</option>
                <option value="tomica">Tomica</option>
                <option value="other">Other</option>
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
                <option value="1:18">1:18</option>
                <option value="1:24">1:24</option>
                <option value="1:32">1:32</option>
                <option value="1:43">1:43</option>
                <option value="1:64">1:64</option>
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
                value="good-condition"
              />
              <label for="good-condition">Good Condition</label>


              <input
                type="checkbox"
                id="near_mint"
                name="model-condition"
                value="near_mint"
              />
              <label for="near_mint">Near Mint</label>

              <input
                type="checkbox"
                id="non-mint"
                name="model-condition"
                value="non-mint"
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
            <label for="product-image">Product Image</label>
            <input type="file" id="product-image" name="product-image" />
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
        <div class="chat-list" id="chat-list">
        <h2>Chat</h2>
          <div class="chat-list-item" onclick="openChat(1)">
            John Doe - <small>Last message: Hi, I have a question...</small>
          </div>
          <div class="chat-list-item" onclick="openChat(2)">
            Jane Smith - <small>Last message: Thanks for the delivery!</small>
          </div>

          <div class="chat-list-item" onclick="openChat(3)">
            Baxter Sisgado - <small>Last message: Mine po..</small>
          </div>
        </div>

        <!-- Right Chat Box -->
       <div class="chat-box" id="chat-box">
      <div class="messages" id="messages">
        <!-- Messages will load here -->
        <div class="message sent">Hello!</div>
        <div class="message received">Hi, how can I help you?</div>
      </div>
      
      <div class="message-input">
        <input type="text" id="message-input" placeholder="Type your message here..." />
        
        <!-- Hidden file input -->
        <input type="file" id="image-input" accept="image/*" style="display: none;" />
        
        <!-- Icon to trigger file selection -->
        <span class="material-symbols-outlined" id="file-icon" onclick="document.getElementById('image-input').click();">
          attach_file
        </span>

        <button onclick="sendMessage()">Send</button>
      </div>
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


      function openEditForm() {
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
        const productPrice = document.getElementById('product-price').value;
        const modelStock = document.getElementById('model_stock').value;
        const modelType = document.getElementById('model-type').value;
        const description = document.getElementById('product-description').value;
        const fileInput = document.querySelector('input[type="file"]'); 

        const tags = Array.from(document.querySelectorAll('input[name="model-tags"]:checked'))
        .map(checkbox => checkbox.value.replace(/_/g, ' '))
        .map(tag => tag.split(' ')
          .map(word => word.charAt(0).toUpperCase() + word.slice(1))
          .join(' ')
        );
      
        const formData = new FormData();
                        
        formData.append('seller_id', sellerId);
        formData.append('size_id', '4');
        formData.append('brand_id', '2');
        formData.append('model_name', productName);
        formData.append('model_description', description);
        formData.append('model_price', productPrice);
        formData.append('model_stock', modelStock);
        formData.append('model_availability', 'Available');
        formData.append('model_tags', tags.length ? tags.join(', ') : '');
        formData.append('model_type', 'Regular');
                             
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
            
            console.log("Product listed");
            
            console.log('Response:', responseData);
            alert('product added')
          } catch (error) {
              console.error('Error during fetch:', error);
          }
        }
      });

    </script>
   
    <script>
       // Sample data for demo purposesReplace this with actual data retrieval in real implementation 
    const messagesData = {
      1: [
        { sender: 'John Doe', text: 'Hi, I have a question about the product.' },
        { sender: 'Seller', text: 'Sure, I’d be happy to help. What’s your question?' },
      ],
      2: [
        { sender: 'Jane Smith', text: 'Thanks for the delivery! Everything is perfect.' },
        { sender: 'Seller', text: 'Glad to hear it! Let me know if you need anything else.' },
      ],
     3: [
        { sender: 'Baxter Sisgado', text: 'Mine po.  NISSAN SKYLINE 2000 GT-X' },
        { sender: 'Seller', text: 'Glad to hear it!' },
      ],
    };

    // Function to open a chat and display messages in the chat box
    function openChat(chatId) {
      const chatBox = document.getElementById('messages');
      chatBox.innerHTML = ''; // Clear previous messages

      const chatMessages = messagesData[chatId];
      
      // Populate the chat box with messages
      chatMessages.forEach((message) => {
        const messageElement = document.createElement('div');
        messageElement.classList.add('message');
        messageElement.innerHTML = `<strong>${message.sender}:</strong> ${message.text}`;
        chatBox.appendChild(messageElement);
      });
    }

 

    </script>
  </body>
</html>
