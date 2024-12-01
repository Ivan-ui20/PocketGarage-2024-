<!-- Modal -->
<div class="modal" id="bidModal">
    <div class="bid-modal-content">
        <span class="close-btn" onclick="closeBidModal()">&times;</span>
        <div class="bid-modal-body">
            <div class="modal-bid-image">
                <img id="modal-bid-image" src="https://via.placeholder.com/400" alt="Product Image">

                 <!-- Link to see details -->
              
                <p>
                    <a href="#" class="details-link" onclick="openDetailsModal()">See Details</a>
                </p>
            </div>
            <div class="bid-modal-info">
                <input type="hidden" id="bidding_id">
                <input type="hidden" id="model_id">
                <h2 class="modal-bid-title" id="modal-bid-title"></h2>
                <p class="modal-bid-seller" id="modal-bid-product-seller">
                    Posted by 
                    <span id="modal-bid-seller-name">
                    </span>
                </p>
                <p class="modal-bid-details" id="modal-bid-details"></p>
                                
                <div class="modal-appraisal-value" >
                    <span>Appraisal Value: ₱</span>                
                    <span id="modal-appraisal-value"></span>
                </div>

                <div class="modal-bid-price" >
                    <span>Highest Bid: ₱</span>
                    <span id="modal-bid-price"></span>
                </div>

                <input type="text" id="modal-bid-start-time">
                <input type="text" id="modal-bid-end-time">

                <!-- New Bid Input Field with Peso Symbol -->
                <div class="bid-input-container" id="bid-input-container">
                    <span class="peso-sign">₱</span>
                    <input type="number" id="bidPrice" class="bid-input" placeholder="0" min="0" oninput="preventNegative(this)">
                </div>
                
                <!-- New Bid Button -->
                <?php if (isset($_SESSION['user_id'])): ?>                  
                    <button class="bid-btn" id="bid-btn">Bid</button>
                    <p id="close-bid">This bid is already closed</p>
                <?php else: ?>
                    <p class="login-prompt">Please log in first to start 
                        bid this item.</p>
                <?php endif; ?>                
            </div>
        </div>
    </div>
</div>



<!-- Success Message -->

<!---for details-----> 

<div class="modal" id="detailsModal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeDetailsModal()">&times;</span>

       
        <div class="modal-body">
           
            <ul class="details-list">
                <li> <h2> Product Details </h2> </li>
            

                <li>
                    <strong>Product Description:</strong>
                    <span id="detail-brand"></span>
                </li>
                <li>
                    <strong>Model Brand:</strong>
                    <span id="detail-brand"></span>
                </li>
                <li>
                    <strong>Model Type:</strong>
                    <span id="detail-type"></span>
                </li>
                <li>
                    <strong>Packaging:</strong>
                    <span id="detail-packaging"></span>
                </li>
                <li>
                    <strong>Scale:</strong>
                    <span id="detail-scale"></span>
                </li>
                <li>
                    <strong>Condition:</strong>
                    <span id="detail-condition"></span>
                </li>
                <li>
                    <strong>Tags:</strong>
                    <span id="detail-tags"></span>
                </li>
            </ul>
           
        </div>
    </div>
</div>

<script>    
function formatDateTime(dateString) {
    const date = new Date(dateString);
    const options = {
        year: "numeric",
        month: "short", // Abbreviated month
        day: "2-digit",
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        hour12: false // 24-hour format
    };
    return date.toLocaleString("en-US", options).replace(/,/g, "");
}

function isDateTimeNowOutsideRange(startTime, endTime) {
    const now = new Date();
    const startDate = new Date(startTime);
    const endDate = new Date(endTime);

    return now < startDate || now > endDate;
}


    
function openBidModal(bidID, modId, image, name, description, 
    price, appraValue, sellerName, startTime, endTime, status) {
    document.getElementById("bidModal").style.display = "flex";

    const biddingId = document.getElementById("bidding_id");
    const modelId = document.getElementById("model_id");
    const modalImage = document.getElementById("modal-bid-image");
    const modalTitle = document.getElementById("modal-bid-title");    
    const modalPrice = document.getElementById("modal-bid-price");
    const modalAppraVal = document.getElementById("modal-appraisal-value");
    const modalDetail = document.getElementById("modal-bid-details");
    const modalSellerName = document.getElementById("modal-bid-seller-name");
    const modalStartTime = document.getElementById("modal-bid-start-time");
    const modalEndTime = document.getElementById("modal-bid-end-time");
    const bidBtn = document.getElementById("bid-btn");
    const bidClosed = document.getElementById("close-bid");
    const bidInput = document.getElementById("bid-input-container")
    const formattedStartTime = formatDateTime(startTime);
    const formattedEndTime = formatDateTime(endTime);
    
    modalImage.src = `http://pocket-garage.com/backend/${image}`;
    modalImage.alt = name;
    modalTitle.textContent = name;        
    modalPrice.textContent = price;
    modalAppraVal.textContent = appraValue;
    biddingId.value = bidID;
    modelId.value = modId;
    modalDetail.textContent = description;
    modalSellerName.textContent = sellerName;
    modalStartTime.value = formattedStartTime;    
    modalEndTime.value = formattedEndTime
        
    if (status === "Closed" || status === "Complete") {
        bidBtn.style.display = "none"
        bidInput.style.display = "none"
        bidClosed.style.display = "block"               
    } else {
        bidBtn.style.display = "block"
        bidInput.style.display = "block"
        bidClosed.style.display = "none"
    }   
}

// Function to close the modal
function closeBidModal() {
  document.getElementById("bidModal").style.display = "none";
}

// Close the modal when clicking outside of it
window.onclick = function(event) {
  const modal = document.getElementById("bidModal");
  if (event.target == modal) {
      modal.style.display = "none";
  }
};

// Prevents negative values in the bid input field
function preventNegative(input) {
  if (input.value < 0) {
      input.value = 0;
  }
}

function placeBid() {
    const bidPrice = document.getElementById("bidPrice").value;
    const biddingId = document.getElementById("bidding_id").value;
    const modelId = document.getElementById("model_id").value;
    const modalPrice = document.getElementById("modal-bid-price").textContent;
    const customerId = "<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; ?>" || null;
    
    const modalStartTime = document.getElementById("modal-bid-start-time").value; 
    const modalEndTime = document.getElementById("modal-bid-end-time").value;

    // Ensure formatDateTime is used if necessary to display formatted output
    if (isDateTimeNowOutsideRange(modalStartTime, modalEndTime)) {
        alert("This bid is already closed.")
        return;
    } 
    if(!customerId) return
    if (bidPrice > parseFloat(modalPrice)) {
            // Show success message
            const successMessage = document.getElementById("successMessage");
            successMessage.style.display = "block";
            
            const data = new URLSearchParams({                    
                bidding_id: biddingId,
                model_id: modelId,
                customer_id: customerId,
                amount: bidPrice
            });

            fetch('/backend/src/customer/route.php?route=customer/place/bid', {
                method: 'POST',
                body: data.toString(),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
                alert(data.message)
                window.location.reload();
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            }); 

            // Hide the message after a short delay
            setTimeout(() => {
                successMessage.style.display = "none";
            }, 3000); // Hide after 3 seconds
    } else {
        alert("Please enter a valid bid price.");
    }
}

// Attach the placeBid function to the Bid button
document.querySelector(".bid-btn").addEventListener("click", placeBid);


  // Function to open the product details modal
  function openDetailsModal() {
        document.getElementById("detailsModal").style.display = "flex";
    }

    // Function to close the product details modal
    function closeDetailsModal() {
        document.getElementById("detailsModal").style.display = "none";
    }

    /*samplebid closes time
    function updateBidCloseTime(closingTime) {
    // Convert closing time string to a Date object
    const closeDate = new Date(closingTime);

    // Format the date and time as needed
    const formattedCloseTime = closeDate.toLocaleString('en-PH', {
        weekday: 'short', year: 'numeric', month: 'short', day: 'numeric',
        hour: '2-digit', minute: '2-digit'
    });

    // Set the formatted time into the modal
    document.getElementById("modal-bid-close-time").textContent = formattedCloseTime;
        }

        // Example: Set the bid close time to '2024-12-05 15:30:00'
        updateBidCloseTime('2024-12-05T15:30:00');
        */
</script>



<style>
/* Bid input container styling */

.bid-modal-content {
    background-color: #fff;
    padding: 20px;
    width: 70%; /* Increased width */
    max-width: 90%; /* Adjust as needed */
    border-radius: 8px;
    position: relative;
}

.bid-input-container {
    margin-top: 15px;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
}

/* Appraisal and highest bid values */
.modal-appraisal-value, .modal-bid-price {
    font-size: 1.2rem;
    margin-top: 10px;
}


.bid-modal-info {
    font-size: 1.2rem; /* Increase font size */
    line-height: 1.5; /* Increase line height for readability */
    width: 100%; /* Make it take up more space */
}

.bid-input {
    font-size: 1.2rem; /* Larger input font */
    padding: 10px;
    width: 100%;
    max-width: 200px;
}


.bid-btn {
    margin-top: 15px;
    padding: 10px 20px;
    font-size: 1.2rem;
    background-color: #007bff;
    color: #fff;
    border: none;
    cursor: pointer;
    border-radius: 4px;
}

.bid-btn:hover {
    background-color: #0056b3;
}

/* Styling the Details List */
.details-list {
    list-style-type: none; /* Remove default bullets */
    padding: 0; /* No padding */
    margin: 0; /* No margin */
    font-size: 1.1rem; /* Set font size for list items */
    color: #555; /* Text color */
    line-height: 1.6; /* Line spacing */
}

.details-list li {
    margin-bottom: 10px; /* Add space between items */
    display: flex; /* Use flexbox for alignment */
    flex-wrap: wrap; /* Allow content to wrap to the next line */
    gap: 5px; /* Space between the label and value */
}

.details-list li strong {
    font-weight: bold; /* Emphasize the labels */
    color: #333; /* Darker color for labels */
}

.details-list li span {
    display: inline-block; /* Ensures proper wrapping */
    word-break: break-word; /* Prevents long text from breaking the layout */
}

/* Modal Styling */
#detailsModal .modal {
    display: none; /* Hidden by default */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Dark overlay */
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

#detailsModal .modal-content {
    background-color: #fff;
    border-radius: 8px;
    padding: 20px;
    width: 70%; /* Increased width */
    height: 60%;
    max-width: 800px; /* Adjust as needed */
    max-height: 800px; /* Adjust as needed */
    position: relative;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

#detailsModal .modal-body h2 {
    margin-bottom: 10px;
    font-size: 1.5rem;
    color: #333;
    text-align: center;
}

/* Button Styling */
.details-to-bid-btn {
    margin-top: 20px;
    padding: 10px 20px;
    font-size: 1.2rem;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-align: center;
    width: 100%;
    box-sizing: border-box;
}

.details-to-bid-btn:hover {
    background-color: #0056b3;
}

/* Close Button */
.close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 1.5rem;
    color: #333;
    cursor: pointer;
    transition: color 0.3s ease;
}

.close-btn:hover {
    color: #d9534f;
}


/* Modal Title Styling */
.modal-title {
    margin-bottom: 5px; /* Add spacing below the heading */
    font-size: 1.5rem;
    color: #333;
    text-align: center; /* Center align the title */
    display: block; /* Ensure the title takes up its own line */
}



</style>

