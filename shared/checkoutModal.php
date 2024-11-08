<div class="checkout-modal-container">
        <div class="checkout-modal">
            <!-- Left side: Checkout form -->
            <div class="checkout-form-section">
                <h2>Checkout</h2>
                
                <form class="checkout-form">
                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required>
    
                    <label for="phonenumber">Phone Number</label>
                    <input type="tel" id="phonenumber" name="phonenumber" placeholder="Enter your phone number" required>
    
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" placeholder="Enter your address" required>
    
                    <div class="shipping-method">
                        <h3>Shipping Method</h3>
                        <label for="cod">
                            <input type="radio" id="cod" name="shipping" value="cod" checked> Cash on Delivery (CoD)
                        </label>
                    </div>
                    <button type="submit">Place Order</button>
                </form>
            </div>
    
            <!-- Right side: Product details -->
            <div class="product-details">
                <div class="product-info">
                    <img src="product-image.jpg" alt="Product Image" class="product-image">
                    <div class="product-description">
                        <h3>Product Name</h3>
                        <p>A short description of the product goes here.</p>
                    </div>
                </div>
                <div class="product-total">
                    <p>Total:</p>
                    <p class="price">₱99.99</p>
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

// Close the confirmation modal without placing the order
function closeConfirmation() {
    document.getElementById('confirmationModal').style.display = 'none';
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
    display: flex;
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