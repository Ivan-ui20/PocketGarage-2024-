
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
        background: url('assets/BGM.jpg');
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
            <li>
              <a href="#" onclick="showSection('add-product-section')">
                <span class="material-symbols-outlined">sell</span>
                <h3>Add Product</h3>
              </a>
            </li>
            <li>
              <a href="#">
                <span class="material-symbols-outlined">inventory</span>
                <h3>Auction</h3>
              </a>
            </li>
            <li>
              <a href="#">
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
              <a href="#">
                <span class="material-symbols-outlined">logout</span>
                <h3>Logout</h3>
              </a>
            </li>
          </ul>
      </div>
      <div id="nav-bar">
          <ul>
            <li>
              <a href="#" class="logo">
                <img src="./assets/BG.PNG" alt="Logo" />
              </a>
            </li>

            <li class="profile" >
              <div class="Info">
                <p><b>Ivan Garcia</b></p>
                <p>Seller</p>
              </div>
              <div class="profile-photo">
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
          <label for="model-type">Model Type</label>
          <select id="model-type" name="model-type" required>
            <option value="physical">Physical</option>
            <option value="digital">Digital</option>
          </select>
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
      <ul class="customer-list">
        <li>John Doe - johndoe@gmail.com</li>
        <li>Jane Smith - janesmith@yahoo.com</li>
        <li>Michael Johnson - mjohnson@hotmail.com</li>
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
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>#001</td>
            <td>John Doe</td>
            <td>Car Engine</td>
            <td>Shipped</td>
          </tr>
          <tr>
            <td>#002</td>
            <td>Jane Smith</td>
            <td>Tire Set</td>
            <td>Processing</td>
          </tr>
        </tbody>
      </table>
    </div>

    <script>

      function showSection(sectionId) {
        const sections = document.querySelectorAll(".section");
        sections.forEach((section) => section.classList.remove("visible"));

        const selectedSection = document.getElementById(sectionId);
        if (selectedSection) {
          selectedSection.classList.add("visible");
        }
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
  </body>
</html>
