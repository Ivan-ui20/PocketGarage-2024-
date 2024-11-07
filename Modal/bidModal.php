<!-- Modal -->
<div class="modal" id="productModal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <div class="modal-body">
            <div class="modal-image">
                <img src="https://via.placeholder.com/400" alt="Product Image">
            </div>
            <div class="modal-info">
                <h2 class="modal-title">Product Name</h2>
                <p class="modal-description">
                    This is a detailed description of the product, including its features, specifications, and other relevant information.
                </p>
                <div class="modal-price">
                    <span>₱49.99</span>
                </div>

                <!-- New Bid Input Field with Peso Symbol -->
                <div class="bid-input-container">
                    <span class="peso-sign">₱</span>
                    <input type="number" id="bidPrice" class="bid-input" placeholder="0" min="0" oninput="preventNegative(this)">
                </div>

                <!-- New Bid Button -->
                <button class="bid-btn">Bid</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Message -->
<div id="successMessage" class="success-message">
    Your bid has been successfully placed!
</div>


<script>
    // Function to open the modal
function openBidModal() {
  document.getElementById("productModal").style.display = "flex";
}

// Function to close the modal
function closeBidModal() {
  document.getElementById("productModal").style.display = "none";
}

// Close the modal when clicking outside of it
window.onclick = function(event) {
  const modal = document.getElementById("productModal");
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
  if (bidPrice > 0) {
      // Show success message
      const successMessage = document.getElementById("successMessage");
      successMessage.style.display = "block";
      
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
