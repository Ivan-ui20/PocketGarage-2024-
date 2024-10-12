<div id="checkout-modal" class="checkout-modal" style="display: none;">
    <div class="checkout-modal-content">
        <h4>Checkout</h4>
        <span class="close-checkout">&times;</span>
        
        <!-- Product Details Section -->
        <div id="checkout-product-list" class="checkout-product-list">
            <!-- Product items will be dynamically inserted here -->
        </div>

        <div class="checkout-total">
            <p><strong>Total Price:</strong> <span id="checkout-total-price">₱0.00</span></p>
        </div>

        <form id="checkout-form">
            <button type="submit" class="submit-checkout">Place Order</button>
        </form>
    </div>
</div>

<script>
    
    document.addEventListener('DOMContentLoaded', () => {
        const checkoutModal = document.getElementById('checkout-modal');
        const closeCheckout = document.querySelector('.close-checkout');        
        closeCheckout.addEventListener('click', function() {
            checkoutModal.style.display = 'none';
        });
        // Optionally, close the modal if the user clicks outside of it
        window.addEventListener('click', function(event) {
            if (event.target == checkoutModal) {
                checkoutModal.style.display = 'none';
            }
        });
     
        document.getElementById('checkout-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the page from refreshing
            alert('Order has been placed! Thank you for shopping.');
            const items = document.getElementById('cart-items')
            console.log(items);
            
            // Clear the cart and reset form (if applicable)
            document.getElementById('cart-items').innerHTML = '';  // Clear cart items
            document.getElementById('cart-total-price').textContent = '₱0.00';  // Reset total price

            checkoutModal.style.display = 'none'; // Close the checkout modal after submission
        });

        document.getElementById('checkout-btn').addEventListener('click', function () {
            if (cartItems.length > 0) {
                checkoutModal.style.display = 'block';
                alert('Proceeding to checkout...');
                // Implement your checkout logic here
            } else {                
                alert('Your cart is empty!');
                
            }
        });
    })
    
</script>