<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BidModal with Side-by-Side Layout</title>
    <link rel="stylesheet" href="productModal.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>
<body></body>

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

<script>
    // Function to open the modal
function openModal() {
  document.getElementById("productModal").style.display = "flex";
}

// Function to close the modal
function closeModal() {
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
</script>
