<div class="modal" id="productModal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeProductModal()">&times;</span>
        <div class="modal-body">
            <div class="modal-image">
                <img src="https://via.placeholder.com/400" alt="Product Image" id="modal-product-image">            
            </div>
            <div class="modal-info">
                 <!-- Add Model Brand/Model Type/Packaging/UnopenedScale/CONDITION/model tag-->


                <input type="hidden" id="modal-seller-id" value="">
                <h2 class="modal-title" id="modal-product-title"></h2>
                <p class="modal-seller" id="modal-product-seller">Posted by <span id="modal-seller-name"></span></p>
                <p class="modal-description" id="modal-product-description"></p>

                  <!-- Additional Product Details -->
                    <p class="modal-details">Brand: <span id="modal-product-brand"></span></p>
                    <p class="modal-details">Model Type:<span id="modal-product-model-type"></span></p>
                    <p class="modal-details">Packaging: <span id="modal-product-packaging"></span></p>
                    <p class="modal-details">Scale: <span id="modal-product-scale"></span></p>
                    <p class="modal-details">Condition:<span id="modal-product-condition"></span></p>

                <p class="modal-description" id="modal-product-stock"></p>
                <div class="modal-price" id="modal-product-price">  
                    <span></span>
                </div>
                <div class="modal-buttons">

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="#" id="chat-icon">
                            <i class='bx bx-chat'></i>
                        </a>
                    <?php endif; ?>

               
                    <h2 id="out-of-stock-message" style="display: none;">Out of Stock</h2> 
                    <div id="modal-buttons1">                        
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <button 
                                class="add-to-cart-btn-modal add-to-cart-btn" 
                                id="modal-cart"
                                data-product-id=""
                                data-product-name=""
                                data-product-description=""
                                data-product-image=""
                                data-product-price=""
                                data-product-type=""
                                >Add to Cart</button>
                            <button id="cart-icon1" class="checkout-btn-pmodal">Checkout</button>
                        <?php else: ?>
                            <p class="login-prompt">Please log in to add items to your cart.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

