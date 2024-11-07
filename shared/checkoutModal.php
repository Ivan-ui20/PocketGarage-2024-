<div id="checkout-modal" class="checkout-modal" style="display: none;">
    <div class="checkout-modal-content">
        <h4>Checkout</h4>
        <span class="close-checkout">&times;</span>
        
        <!-- Product Details Section -->
        <ul id="checkout-product-list" class="checkout-product-list">
            <!-- Product items will be dynamically inserted here -->
        </ul>

        <div class="checkout-total">
            <p><strong>Total Price: ₱</strong> <span id="checkout-total-price"></span></p>
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

            const totalPriceStr = checkoutTotalPrice.textContent.replace(/[^\d.]/g, ''); // Keep digits and decimal point
            const totalPrice = parseFloat(totalPriceStr);
                        
            const data = new URLSearchParams({                    
                customer_id: sessionStorage.getItem("userId"),                
                shipping_addr: "shipping address",                
                order_total: totalPrice,
                order_payment_option: "Cash on delivery",
                items : JSON.stringify(cartItems),
                cart_id: sessionStorage.getItem("cartId")
            });
            
            
            fetch('/backend/src/customer/route.php?route=customer/send/order', {
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
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
            
            // Clear the cart and reset form (if applicable)
            cartItems = []
            updateCartModal()
            cartCountElement.textContent = 0
            checkoutModal.style.display = 'none'; // Close the checkout modal after submission
        });

        
    })
    
</script>