const header =document.querySelector("header");

let counter = 1;
setInterval(function() {
    document.getElementById('radio' + counter).checked = true;
    counter++;
    if (counter > 3) {
        counter = 1;
    }
}, 5000);

//Login
document.addEventListener('DOMContentLoaded', () => {
    const signupLink = document.getElementById('signup-link');
    const loginLink = document.getElementById('login-link');
    const loginForm = document.querySelector('.login-form');
    const signupForm = document.querySelector('.signup-form');

    signupLink.addEventListener('click', () => {
        loginForm.style.display = 'none';
        signupForm.style.display = 'block';
    });

    loginLink.addEventListener('click', () => {
        signupForm.style.display = 'none';
        loginForm.style.display = 'block';
    });
});




// Toggle submenu display on click (optional for touch devices)
document.addEventListener('DOMContentLoaded', function() {
    const dropdown = document.querySelector('.navmenu .dropdown');

    dropdown.addEventListener('click', function(event) {
        event.stopPropagation();
        this.querySelector('.submenu').classList.toggle('show');
    });

    document.addEventListener('click', function() {
        document.querySelector('.submenu').classList.remove('show');
    });
});



//Cart 
document.addEventListener('DOMContentLoaded', function () {
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    const cartCountElement = document.getElementById('cart-count');
    const cartModal = document.getElementById('cart-modal');
    const closeModal = document.querySelector('.cart-modal .close');
    const cartItemsElement = document.getElementById('cart-items');
    const cartTotalPriceElement = document.getElementById('cart-total-price');
    const checkoutBtn = document.getElementById('checkout-btn');
    let cartItems = [];

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-product-id');
            const productName = this.getAttribute('data-product-name');
            const productImage = this.getAttribute('data-product-image');
            const productPrice = parseFloat(this.getAttribute('data-product-price').replace(/[^0-9.-]+/g,"")); // Convert to number
            
            const existingItemIndex = cartItems.findIndex(item => item.id === productId);
            if (existingItemIndex === -1) {
                cartItems.push({ id: productId, name: productName, image: productImage, price: productPrice, quantity: 1 });
            } else {
                cartItems[existingItemIndex].quantity += 1;
            }
            cartCountElement.textContent = cartItems.reduce((sum, item) => sum + item.quantity, 0);
            alert(productName + ' has been added to the cart!');
        });
    });

    document.getElementById('cart-icon').addEventListener('click', function (e) {
        e.preventDefault();
        updateCartModal();
        cartModal.style.display = 'block';
    });

    closeModal.addEventListener('click', function () {
        cartModal.style.display = 'none';
    });

    window.addEventListener('click', function (event) {
        if (event.target == cartModal) {
            cartModal.style.display = 'none';
        }
    });

    cartItemsElement.addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-btn')) {
            const index = event.target.getAttribute('data-index');
            cartItems.splice(index, 1);
            cartCountElement.textContent = cartItems.reduce((sum, item) => sum + item.quantity, 0);
            updateCartModal();
        } else if (event.target.classList.contains('quantity-increase')) {
            const index = event.target.getAttribute('data-index');
            cartItems[index].quantity += 1;
            updateCartModal();
        } else if (event.target.classList.contains('quantity-decrease')) {
            const index = event.target.getAttribute('data-index');
            if (cartItems[index].quantity > 1) {
                cartItems[index].quantity -= 1;
                updateCartModal();
            }
        }
    });

    checkoutBtn.addEventListener('click', function () {
        if (cartItems.length > 0) {
            alert('Proceeding to checkout...');
            // Implement your checkout logic here
        } else {
            alert('Your cart is empty!');
        }
    });

    function updateCartModal() {
        cartItemsElement.innerHTML = '';
        let totalPrice = 0;
        cartItems.forEach((item, index) => {
            const li = document.createElement('li');
            li.innerHTML = `
                <div class="cart-item">
                    <img src="${item.image}" alt="${item.name}">
                    <div class="cart-item-details">
                        <span>${item.name}</span>
                        <span>₱${item.price.toFixed(2)}</span>
                        <div class="quantity-controls">
                            <button class="quantity-decrease" data-index="${index}">-</button>
                            <span>${item.quantity}</span>
                            <button class="quantity-increase" data-index="${index}">+</button>
                        </div>
                        <button class="remove-btn" data-index="${index}">Remove</button>
                    </div>
                </div>
            `;
            cartItemsElement.appendChild(li);
            totalPrice += item.price * item.quantity;
        });

        // Format total price with commas
        cartTotalPriceElement.textContent = `₱${totalPrice.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    }
    
})
// Searchbar
document.addEventListener('DOMContentLoaded', function() {
    // Get the search query from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const query = urlParams.get('query') ? urlParams.get('query').toLowerCase() : '';

    // Select all product boxes
    const productBoxes = document.querySelectorAll('.product-box');

    // If there's a search query, filter products based on the query
    if (query) {
        productBoxes.forEach(box => {
            const productName = box.querySelector('.product-text h4').innerText.toLowerCase();
            // Check if product name includes the query
            if (productName.includes(query)) {
                box.classList.remove('hidden'); // Show product if it matches the query
            } else {
                box.classList.add('hidden'); // Hide product if it does not match the query
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const loginBtn = document.getElementById("login-btn");
    const rememberMeCheckbox = document.getElementById("remember-me");
    
    const phoneField = document.getElementById("phone-number"); // Phone field used in both forms
    const passwordField = document.getElementById("password");  // Password field for login
    const signupPhoneField = document.getElementById("signup-phone-number"); // Updated Phone field for signup
    const signupPasswordField = document.getElementById("signup-password"); // Updated Password field for signup
    

    // Login form validation and remember me functionality
    loginBtn.addEventListener("click", function() {
        
        const phoneError = document.getElementById("phone-error");
        const passwordError = document.getElementById("password-error");
        let loginValid = true;

        // Clear previous error messages
        phoneError.textContent = "";
        passwordError.textContent = "";

        // Validate phone number (exactly 11 digits)
        if (!phoneField.value || phoneField.value.length !== 11) {
            phoneField.style.borderColor = "red";
            phoneError.textContent = "Please enter a valid 11-digit phone number.";
            loginValid = false;
        } else {
            phoneField.style.borderColor = "";
        }

        // Validate password field (ensure it's filled)
        if (!passwordField.value) {
            passwordField.style.borderColor = "red";
            passwordError.textContent = "Password is required.";
            loginValid = false;
        } else {
            passwordField.style.borderColor = "";
        }

        if (loginValid) {
            // Handle Remember Me and login logic
            const phoneNumber = phoneField.value;
            const password = passwordField.value;

            if (rememberMeCheckbox.checked) {
                localStorage.setItem("phone-number", phoneNumber);
                localStorage.setItem("password", password);
            } else {
                localStorage.removeItem("phone-number");
                localStorage.removeItem("password");
            }

            alert("Logged in!");
        } else {
            alert("Please fill in all fields correctly.");
        }
    });

    // Remember Me logic for login form (auto-fill phone number and password if saved)
    if (localStorage.getItem("phone-number")) {
        phoneField.value = localStorage.getItem("phone-number");
        passwordField.value = localStorage.getItem("password");
        rememberMeCheckbox.checked = true;
    }

    // Restrict phone number input to numeric only
    phoneField.addEventListener("input", function () {
        phoneField.value = phoneField.value.replace(/\D/g, "");
        if (phoneField.value.length > 11) {
            phoneField.value = phoneField.value.slice(0, 11);
        }
    });

    // Sign-up form: Move to the next step only if all fields are filled correctly
    const nextBtn = document.getElementById("next-btn");
    const signupStep1 = document.getElementById("signup-step-1");
    const signupStep2 = document.getElementById("signup-step-2");

    nextBtn.addEventListener("click", function() {
        const inputs = signupStep1.querySelectorAll("input");
        let allFilled = true;

        // Clear previous error messages
        const errorMessages = signupStep1.querySelectorAll(".error-message");
        errorMessages.forEach(msg => {
            msg.textContent = "";
        });

        // Check if all fields are filled and validate phone number and password
        inputs.forEach(input => {
            const errorMsgElement = document.getElementById(input.id + "-error");
            if (!input.value) {
                allFilled = false;
                input.style.borderColor = "red"; // Highlight empty fields
                errorMsgElement.textContent = "This field is required."; // Set error message
            } else {
                input.style.borderColor = ""; // Reset border color if filled
            }
        });


        // Validate phone number field (should be exactly 11 digits)
        const signupPhoneErrorMsg = document.getElementById("signup-phone-number-error");
        if (signupPhoneField.value.length !== 11) {
            allFilled = false;
            signupPhoneField.style.borderColor = "red"; // Highlight invalid phone number
            signupPhoneErrorMsg.textContent = "Please enter a valid 11-digit phone number."; // Set error message
        } else {
            signupPhoneField.style.borderColor = ""; // Reset border color if valid
        }

        // Validate password field (Check if it's filled)
        const signupPasswordErrorMsg = document.getElementById("signup-password-error");
        if (!signupPasswordField.value) {
            allFilled = false;
            signupPasswordField.style.borderColor = "red"; // Highlight empty password
            signupPasswordErrorMsg.textContent = "Password is required."; // Set error message
        } else {
            signupPasswordField.style.borderColor = ""; // Reset border color if filled
        }

        if (allFilled) {
            // Hide the first step and show the second step
            signupStep1.style.display = "none";
            signupStep2.style.display = "block";
        } else {
            alert("Please fill all fields correctly.");
        }
    });

    // Back button functionality for sign-up form
    const backBtn = document.getElementById("back-btn");

    backBtn.addEventListener("click", function() {
        signupStep2.style.display = "none"; // Hide step 2
        signupStep1.style.display = "block"; // Show step 1
    });

    // Restrict phone number input to numeric only for the signup form
    signupPhoneField.addEventListener("input", function () {
        signupPhoneField.value = signupPhoneField.value.replace(/\D/g, "");
        if (signupPhoneField.value.length > 11) {
            signupPhoneField.value = signupPhoneField.value.slice(0, 11);
        }
    });
    
    document.getElementById('login-btn').addEventListener('click', function () {
        const phoneNumber = document.getElementById('phone-number').value;
        const password = document.getElementById('password').value;
    
        // Example validation (this should be replaced with real validation)
        if (phoneNumber === '12345678910' && password === 'buyer') {
            window.location.href = 'index.html'; // Redirect to home page
        } else {
            document.getElementById('phone-error').textContent = 'Invalid phone number or password.';
            document.getElementById('password-error').textContent = 'Invalid phone number or password.';
        }
    });
});