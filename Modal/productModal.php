

<div class="modal" id="productModal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeProductModal()">&times;</span>
        <div class="modal-body">
            <div class="modal-image">
                <img src="https://via.placeholder.com/400" alt="Product Image" id="modal-product-image"> 
            </div>
            <div class="modal-info">
                <h2 class="modal-title" id="modal-product-title"></h2>
                <p class="modal-description" id="modal-product-description"></p>
                <p class="modal-description" id="modal-product-stock"></p>
                <div class="modal-price" id="modal-product-price">
                    <span></span>
                </div>
                <div class="modal-buttons">
                    <a href="#" id="chat-icon">
                        <i class='bx bx-chat' ></i>
                    </a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <button 
                            data-product-id=""
                            data-product-name=""
                            data-product-image=""
                            data-product-price=""
                            class="add-to-cart-btn-modal" id="modal-cart">Add to Cart</button>
                        <button id="checkout-btn-pmodal" class="checkout-btn-pmodal">Checkout</button>
                    <?php else: ?>
                        <p class="login-prompt">Please log in to add items to your cart.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>// Function to open the modal

function openProductModal(id, image, name, description, stock, price) {
    document.getElementById("productModal").style.display = "flex";

    const modalImage = document.getElementById("modal-product-image");
    const modalTitle = document.getElementById("modal-product-title");
    const modalDescription = document.getElementById("modal-product-description");
    const modalStock = document.getElementById("modal-product-stock");
    const modalPrice = document.getElementById("modal-product-price");
    const modalCart = document.getElementById("modal-cart");

    modalImage.src = `http://localhost:3000/backend/${image}`;
    modalImage.alt = name;
    modalTitle.textContent = name;
    modalDescription.textContent = description;
    modalStock.textContent = `Available stocks: ${stock}`;
    modalPrice.innerHTML = `<span>₱${price}</span>`;

    modalCart.dataset.productId = id;
    modalCart.dataset.productName = name;
    modalCart.dataset.productImage = image;
    modalCart.dataset.productPrice = price;
}

// Function to close the modal
function closeProductModal() {
  document.getElementById("productModal").style.display = "none";
}

// Close the modal when clicking outside of it
window.onclick = function(event) {
  const modal = document.getElementById("productModal");
  if (event.target == modal) {
      modal.style.display = "none";
  }
};

</script>
