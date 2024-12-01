<!-- Modal -->
<div class="modal" id="bidModal">
    <div class="bid-modal-content">
        <span class="close-btn" onclick="closeBidModal()">&times;</span>
        <div class="bid-modal-body">
            <div class="modal-bid-image">
                <img id="modal-bid-image" src="https://via.placeholder.com/400" alt="Product Image">
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
</script>

<style>
/* Bid input container styling */

.bid-modal-content {
    background-color: #fff;
    padding: 20px;
    width: 70%; /* Increased width */
    max-width: 800px; /* Adjust as needed */
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

</style>