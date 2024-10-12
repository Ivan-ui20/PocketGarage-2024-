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

    <link rel="stylesheet" href="seller.css" />
  </head>

  <body>
    <div class="container">
      <!-- section start-->
      <aside>
        <div class="top">
          <div class="logo">
            <h2>
              <span class="gray">POCKET</span
              ><span class="danger"> GARAGE </span>
            </h2>
          </div>
          <dv class="close">
            <span class="material-symbols-outlined"> close </span>
          </dv>
        </div>
        <!-- END OF TOP-->

        <div class="sidebar">
          <a href="#">
            <span class="material-symbols-outlined"> grid_view </span>
            <h3>Dashboard</h3>
          </a>

          <a href="#">
            <span class="material-symbols-outlined"> show_chart </span>
            <h3>Analytics</h3>
          </a>

          <a href="#" >
            <span class="material-symbols-outlined"> group </span>
            <h3>Customers</h3>
          </a>

          <a href="#">
            <span class="material-symbols-outlined"> sell </span>
            <h3>Add product</h3>
          </a>

          <a href="#">
            <span class="material-symbols-outlined"> inventory </span>
            <h3>Auction</h3>
          </a>
          <a href="#">
            <span class="material-symbols-outlined"> mail </span>
            <h3>Messages</h3>
            <span class="msg_count">3</span>
          </a>
          <a href="#">
            <span class="material-symbols-outlined"> lab_profile </span>
            <h3>Reports</h3>
          </a>
         

          <a href="#">
            <span class="material-symbols-outlined"> logout </span>
            <h3>Logout</h3>
          </a>
        </div>
      </aside>
      <!-- section end-->

      <!--main section start-->
     
      <main id="main-section">
            <div class="add-product-container" class = "active">
                <h2>Add New Product</h2>
                <form action="#" method="POST">
                    <label for="product-name">Product Name</label>
                    <input type="text" id="product-name" name="product-name" placeholder="Enter product name" />

                    <label for="product-price">Price</label>
                    <input type="number" id="product-price" name="product-price" placeholder="Enter product price" />

                    <label for="product-description">Description</label>
                    <textarea id="product-description" name="product-description" rows="4" placeholder="Enter product description"></textarea>

                    <label for="product-image">Product Image</label>
                    <input type="file" id="product-image" name="product-image" />

                    <div class="button-group">
                        <button type="submit" class="btn sell-btn">Sell Product</button>
                        <button type="reset" class="btn cancel-btn">Cancel</button>
                    </div>
                </form>
            </div>
        </main>







      <!--main section end-->

      <div class="right">
        <div class="top">
          <button id="menu_bar">
            <span class="material-symbols-outlined"> menu </span>
          </button>

          <div class="profile">
            <div class="Info">
              <p><b>Ivan Garcia</b></p>
              <p>Seller</p>
              <small class="text-muted"></small>
            </div>
            <div class="profile-photo">
              <img src="profile.jpeg" alt="" />

            </div>
        </div>

        </div>


        <!--end-0f-top-->
        <!--start orecentupdate-->
        
        <div class="recent_update">
          <h2>Recent Update</h2>

        <div class="Updates">
          <div class ="Update">
            <div class="profile-photo">
              <img src="profile.jpeg" alt="">
            </div>
            <div class="message">
              <p><b>Ivan Sisgado</b> Received his order</p>
            </div>
          </div>
          </div>
            
        </div>

        <!--end of recent-->

        <!--sales analytic-->

        <div class="sales_analytics">
          <h2> Sales Analytics</h2>

          <div class="Item_online">
            <div class="icon">
            <span class="material-symbols-outlined">shopping_cart</span>
            </div>
            <div class="right-text">
              <div class="info">
                <h3> online orders</h3>
                <small class="text-muted">Last seen 2 hours</small>
              </div>
              <h5 class="danger">-17%</h5>
              <h3>20</h3>
            </div>

          </div>
        </div>
        






         
      </div>


    </div>

    <script src="sellerside.js"></script>
  </body>
</html>