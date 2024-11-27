<div class="checkout-modal-container" id="checkout-modal-container">
        <div class="checkout-modal">
            <!-- Left side: Checkout form -->
            <div class="checkout-form-section">
                <h2>    <span class="close" onclick="closeCheckoutModal()">&times;</span> Checkout</h2>
                                
                <form class="checkout-form" id="checkout-form">
                    <label for="fullname">Shipping Address</label>
                    <input type="text" id="shipping-addr" name="shipping-addr" placeholder="Enter your shipping address" required>
                                
                    <div class="shipping-method">
                        <h3>Shipping Method</h3>
                        <label for="cod">
                            <input type="radio" id="cod" name="shipping" value="Cash on Delivery (CoD)" checked> Cash on Delivery (CoD)
                        </label>
                    </div>
                    <button type="submit">Place Order</button>
                </form>
            </div>

            <!-- Right side: Product details -->
            <div>                           
                <ul id="cart-items">
                </ul>

                <div class="cart-total">
                    <strong>Total: </strong> <span id="cart-total-price"></span>
                </div>
            </div>
        </div>
    </div>

<script>
   // Show the confirmation modal
function showConfirmation() {
    document.getElementById('confirmationModal').style.display = 'flex';
}

// Confirm the order
function confirmOrder() {
    alert("Order placed successfully!");
    document.getElementById('confirmationModal').style.display = 'none';

    // Optionally, submit the form or take any other action here
    // document.getElementById('checkoutForm').submit();
}

document.getElementById('checkout-form').addEventListener('submit', function(event) {
    event.preventDefault(); 
    alert('Order has been placed! Thank you for shopping.');

    const totalPriceStr = document.getElementById("cart-total-price").textContent.replace(/[^\d.]/g, ''); 
    const totalPrice = parseFloat(totalPriceStr);
    const shippingAddress = document.getElementById("shipping-addr").value;    
    const shippingMethod = document.querySelector('input[name="shipping"]:checked').value;
    const customerId = "<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; ?>" || null;
    if(!customerId) return
    const data = new URLSearchParams({
        customer_id: customerId,                
        shipping_addr: shippingAddress,                
        order_total: totalPrice,
        order_payment_option: shippingMethod,
        items : JSON.stringify(cartItems),
        cart_id: localStorage.getItem("cartId")
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
        if(data.success === "Success"){
            cartItems = []
            updateCartModal()
            cartCountElement.textContent = 0
            checkoutModal.style.display = 'none'; // Close the checkout modal after submission
            document.getElementById('checkout-form').reset()
        }
        alert(data.message)
        
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
    
    // Clear the cart and reset form (if applicable)
   
});

// Close the confirmation modal without placing the order
function closeConfirmation() {
    document.getElementById('confirmationModal').style.display = 'none';
}  

function closeCheckoutModal() {
    const checkout = document.getElementById("checkout-modal-container")
    checkout.style.display = 'none';
}
</script>


<style>
/* Center the modal container */
.checkout-modal-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: none;
    align-items: center;
    justify-content: center;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
}

/* Main modal styling */
.checkout-modal {
    display: flex;
    width: 800px;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    font-family: Arial, sans-serif;
}

/* Left column: Checkout form styling */
.checkout-form-section {
    width: 60%;
    padding-right: 20px;
    border-right: 1px solid #ddd;
}

.checkout-form-section h2 {
    margin-top: 0;
    color: #333;
}

.checkout-form {
    display: flex;
    flex-direction: column;
}

.checkout-form label {
    margin-top: 10px;
    font-weight: bold;
    color: #555;
}

.checkout-form input[type="text"],
.checkout-form input[type="tel"],
.checkout-form input[type="number"] {
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}

.checkout-form .shipping-method {
    margin-top: 15px;
}

.shipping-method h3 {
    margin: 0;
    color: #333;
}

.shipping-method label {
    display: flex;
    align-items: center;
    font-weight: normal;
    color: #555;
    margin-top: 5px;
}

.checkout-form button {
    margin-top: 20px;
    padding: 12px;
    border: none;
    border-radius: 5px;
    background-color: #007bff;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.checkout-form button:hover {
    background-color: #0056b3;
}

/* Right column: Product details styling */
.product-details {
    width: 60%;
    padding-left: 20px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.product-info {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.product-image {
    width: 80px;
    height: 80px;
    border-radius: 8px;
    margin-right: 15px;
}

.product-description h3 {
    margin: 0;
    font-size: 18px;
    color: #333;
}

.product-description p {
    font-size: 14px;
    color: #666;
    margin-top: 5px;
}

/* Total Price Row */
.product-total {
    display: flex;
    justify-content: space-between;
    width: 100%;
    font-weight: bold;
    font-size: 16px;
    color: #333;
}

.product-total p {
    margin: 0;
}

.product-total .price {
    font-size: 16px;
    color: #000000;
}
</style>