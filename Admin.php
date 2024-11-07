
<?php

require_once './backend/database/db.php';
session_start();



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
    <title>Pocket Garage - Admin</title>

    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
    />

    <link rel="stylesheet" href="css/admin.css" />
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
        align-items: center;
        position: relative; /* To allow absolute positioning */
      }

      nav ul li.logo {
        flex-grow: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: auto; /* Centers the logo */
      }

        nav ul li.logo a {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: auto; /* Centers the logo */
      }

      nav ul li {
        margin: 10px;
      }
      
      nav li .logo {
        margin-right: 1px  ; /* Reduce spacing between logo and navmenu */
        height: 90px;
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

      .sidebar {
        position: fixed;
        top: 0;
        left:0;
        height: 100vh;
        width: 250px;
        z-index: 1000;
        background-color: rgba(45, 19, 116, 0.274);
        backdrop-filter: blur(10px);
        box-shadow: -10px 0 10px rgb(0, 0, 0, 0.1);
        display: none;
        flex-direction: column;
        align-items: flex-start;
        justify-content: flex-start;
        overflow: hidden; /* Prevent overflow when collapsing */
        transition: height 0.3s ease; 
        overflow-y: auto;
      }

      nav .profile {
        margin-left: auto; /* Pushes profile section to the right */
        display: flex;
        gap: 3rem;
        text-align: left;
        margin-right: 2rem;
      }

      nav .logo {
      display: flex;
      justify-content: center;
      flex-grow: 1; /* Center the logo and make it the main focus */
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
            <li class= >
            <a href="#" onclick="showSection('seller-management-section')">
              <span class="material-symbols-outlined">contacts_product</span>
                <h3>Seller Management</h3>
              </a>
            </li>

            <li>
              <a href="#" onclick="showSection('buyer-management-section')">
              <span class="material-symbols-outlined">contacts_product</span>
                <h3>Buyer Management</h3>
              </a>
            </li>
            <li>
              <a href="#" onclick="showSection('bidding-management-section')">
              <span class="material-symbols-outlined">sell</span>
                <h3>Appraisal and Bidding</h3>
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

        <li class="menubtn" onclick="showSidebar()">  
            <a href="#">
              <span class="material-symbols-outlined">menu</span>
            </a>


            
          </li>
          <li>
            <a href="#" class="logo" onclick="showSection('dashboard-section')">
              <img src="./assets/BG.PNG" alt="Logo" />
            </a>
          </li>
        
          <li class="profile"  >
        

            <div class="profile-photo"  onclick="showSection('user-profile-section')">
              <img src="assets/profile.jpeg" alt="" />
              
            </div>
              
          </li>
       
        </ul>
      </div>
    </nav>

 


    <!-- For Dashboard Section -->
    <div class="content">

        <!-- Dashboard Section -->
        <div id="dashboard-section" class="section">
            <h1>Welcome, Admin</h1>

          <!--start orecentupdate-->
          
          <div class="recent_update">

            <div class="all_pending_registration">
              <h2>All Pending Seller Registration:</h2>

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

              
              </div>
            </div>

        <div class="all_active_bids">

          <h2>All Active Bids:</h2>
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
       
          </div>
          </div>

          <div class="all_active_sellers">
            <h2>All Active Sellers:</h2>
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

              
              </div>
            </div>
              </div>
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

    <!--seller management -->
   
    <div id="seller-management-section" class="section">
    
      <?php include './Admin Panel/sellermanagement.php';?>

    </div>


    <div id="buyer-management-section" class="section">
    
    <?php include './Admin Panel/buyermanagement.php';?>

  </div>

  <div id="bidding-management-section" class="section">
    
    <?php include './Admin Panel/biddingmanagement.php';?>

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
                                  
            alert('product added')
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
        const fileInput = document.getElementById('product-bid-image').files[0];; 
        
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
        formData.append('model_price', 0);
        formData.append('model_stock', 1);
        formData.append('model_availability', 'Available');
        formData.append('model_tags', tags.length ? tags.join(', ') : '');
        formData.append('model_type', productType);
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
                                  
            alert('bid posted')
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
                
        if (status === newStatus || newStatus === "")  {         
          return
        }

        const data = new URLSearchParams({                
          order_id: orderId,
          order_ref_no: refNo,
          order_status: newStatus
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
                                              
          alert('order updated')
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