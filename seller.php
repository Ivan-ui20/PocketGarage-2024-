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

      /* Optional: Sidebar and layout tweaks */
      .sidebar {
        display: none;
        flex-direction: column;
        background-color: #f4f4f4;
        padding: 10px;
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
    </style>
  </head>

  <body>
    <nav>
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
          <a href="#">
            <span class="material-symbols-outlined">lab_profile</span>
            <h3>Reports</h3>
          </a>
        </li>
        <li>
          <a href="#">
            <span class="material-symbols-outlined">logout</span>
            <h3>Logout</h3>
          </a>
        </li>
      </ul>

      <ul>
        <li>
          <a href="#" class="logo">
            <img src="./assets/BG.PNG" alt="Logo" />
          </a>
        </li>

        <li class="profile">
          <div class="Info">
            <p><b>Ivan Garcia</b></p>
            <p>Seller</p>
          </div>
          <div class="profile-photo">
            <img src="assets/profile.jpeg" alt="" />
          </div>
        </li>
        <li onclick="showSidebar()">
          <a href="#">
            <span class="material-symbols-outlined">menu</span>
          </a>
        </li>
      </ul>
    </nav>

    <!-- Add Product Section -->
    <div id="add-product-section" class="section">
      <h2>Add New Product</h2>
      <form action="#" method="POST">
        <div class="form-group">
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

          <label for="model_stock">Stock available:</label>
          <input
            type="number"
            id="model_stock"
            name="model_stock"
            placeholder="Enter number of available stock "
            required
          />
        </div>

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

          <label for="product-description">Description</label>
          <textarea
            id="product-description"
            name="product-description"
            rows="4"
            placeholder="Enter product description"
            required
          ></textarea>

          <label for="product-image">Product Image</label>
          <input type="file" id="product-image" name="product-image" />

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

      function showSidebar() {
        document.querySelector(".sidebar").style.display = "flex";
      }

      function hideSidebar() {
        document.querySelector(".sidebar").style.display = "none";
      }
    </script>
  </body>
</html>
