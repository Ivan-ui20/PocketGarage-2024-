<!-- Modal -->
<div class="modal" id="bidModal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeBidModal()">&times;</span>
        <div class="modal-body">
            <div class="modal-bid-image">
                <img id="modal-bid-image" src="https://via.placeholder.com/400" alt="Product Image">
            </div>
            <div class="modal-info">
                <h2 class="modal-bid-title" id="modal-bid-title"></h2>
                <!-- <p class="modal-bid-description" id="modal-bid-description">
                    This is a detailed description of the product, including its features, specifications, and other relevant information.
                </p> -->
                                
                <div class="modal-appraisal-value" >
                    <span>Appraisal Value: ₱</span> <!--appraisal value is integrated when a seller add productbid. To do, it can be collecting data similar sold product, marketprice, or use of Ebay price"
                </p> -->
                    <span id="modal-appraisal-value"></span>
                </div>

                <div class="modal-bid-price" >
                    <span>Highest Bid: ₱</span>
                    <span id="modal-bid-price"></span>
                </div>

                <!-- New Bid Input Field with Peso Symbol -->
                <div class="bid-input-container">
                    <span class="peso-sign">₱</span>
                    <input type="number" id="bidPrice" class="bid-input" placeholder="0" min="0" oninput="preventNegative(this)">
                </div>
                
                <!-- New Bid Button -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <input type="hidden" id="bidding_id">
                    <input type="hidden" id="model_id">
                    <button class="bid-btn">Bid</button>
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
    // Function to open the modal
function openBidModal(bidID, modId, image, name, description, price, appraValue) {

    document.getElementById("bidModal").style.display = "flex";

    const biddingId = document.getElementById("bidding_id");
    const modelId = document.getElementById("model_id");
    const modalImage = document.getElementById("modal-bid-image");
    const modalTitle = document.getElementById("modal-bid-title");    
    const modalPrice = document.getElementById("modal-bid-price");
    const ModalAppraVal = document.getElementById("modal-appraisal-value");
    
    modalImage.src = `http://pocket-garage.com/backend/${image}`;
    modalImage.alt = name;
    modalTitle.textContent = name;        
    modalPrice.textContent = price
    ModalAppraVal.textContent = appraValue
    biddingId.value = bidID
    modelId.value = modId
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
  if (bidPrice > parseFloat(modalPrice)) {
        // Show success message
        const successMessage = document.getElementById("successMessage");
        successMessage.style.display = "block";
        
        const data = new URLSearchParams({                    
            bidding_id: biddingId,
            model_id: modelId,
            customer_id: sessionStorage.getItem("userId"),
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

.modal-content {
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


.modal-info {
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