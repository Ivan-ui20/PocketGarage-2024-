//Slider
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
    function updateCheckoutModal() {
        const checkoutProductList = document.getElementById('checkout-product-list');
        checkoutProductList.innerHTML = ''; // Clear the product list
    
        let totalPrice = 0;
        cartItems.forEach((item, index) => {
            const productItem = document.createElement('div');
            productItem.className = 'product-item';
    
            const productImage = document.createElement('img');
            productImage.src = item.image;
            productImage.alt = item.name;
    
            const productDetails = document.createElement('div');
            productDetails.className = 'product-item-details';
    
            const productName = document.createElement('span');
            productName.textContent = item.name;
    
            const productPrice = document.createElement('span');
            productPrice.textContent = `₱${item.price.toFixed(2)}`;
    
            const quantityText = document.createElement('span');
            quantityText.textContent = `Quantity: ${item.quantity}`;
    
            productDetails.appendChild(productName);
            productDetails.appendChild(productPrice);
            productDetails.appendChild(quantityText);
    
            productItem.appendChild(productImage);
            productItem.appendChild(productDetails);
    
            checkoutProductList.appendChild(productItem);
    
            totalPrice += item.price * item.quantity;
        });
    
        // Update the total price
        const checkoutTotalPrice = document.getElementById('checkout-total-price');
        checkoutTotalPrice.textContent = `₱${totalPrice.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    }

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

// Get the checkout button and the checkout modal
const proceedToCheckoutBtn = document.getElementById('checkout-btn'); // Renamed variable
const checkoutModal = document.getElementById('checkout-modal');
const closeCheckout = document.querySelector('.close-checkout');

// When the user clicks on the proceed to checkout button, show the checkout modal
proceedToCheckoutBtn.addEventListener('click', function() {
    checkoutModal.style.display = 'block';
    updateCheckoutModal();
});

// When the user clicks on the close button, hide the checkout modal
closeCheckout.addEventListener('click', function() {
    checkoutModal.style.display = 'none';
});

// Optionally, close the modal if the user clicks outside of it
window.addEventListener('click', function(event) {
    if (event.target == checkoutModal) {
        checkoutModal.style.display = 'none';
    }
});

// Handle the checkout form submission
const checkoutForm = document.getElementById('checkout-form');
checkoutForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the page from refreshing
    alert('Order has been placed! Thank you for shopping.');
    const items = document.getElementById('cart-items')
    console.log(items);
    
    // Clear the cart and reset form (if applicable)
    document.getElementById('cart-items').innerHTML = '';  // Clear cart items
    document.getElementById('cart-total-price').textContent = '₱0.00';  // Reset total price

    checkoutModal.style.display = 'none'; // Close the checkout modal after submission
});
    
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
    const phoneField = document.getElementById("phone-number"); // Phone number field
    const passwordField = document.getElementById("password");  // Password field

    // Login action (to avoid code duplication)
    function handleLogin() {
        const phoneError = document.getElementById("phone-error");
        const passwordError = document.getElementById("password-error");
        let loginValid = true;

        // Clear previous error messages
        phoneError.textContent = "";
        passwordError.textContent = "";

        // Validate phone number field (exactly 11 digits)
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
            const data = new URLSearchParams({ 
                contact_number: phoneField.value,               
                password: passwordField.value
            });
            
            fetch('/backend/src/customer/route.php?route=customer/login', {
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
                    
                        if (data.success === "Failed") {
                            phoneError.textContent = 'Invalid phone number or password.';
                            passwordError.textContent = 'Invalid phone number or password.';
                        } else {

                            if (rememberMeCheckbox.checked) {
                                localStorage.setItem("phone-number", phoneNumber);
                                localStorage.setItem("password", password);
                                localStorage.setItem("userId", data.data.user_id)
                            } else {
                                localStorage.removeItem("phone-number");
                                localStorage.removeItem("password");
                            }
            
                            // Redirect to index.html
                            window.location.href = 'index.php';
                        }                                                                    
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });                                
        } else {
            alert("Please fill in all fields correctly.");
        }
    }

    // Trigger login when login button is clicked
    loginBtn.addEventListener("click", handleLogin);

    // Trigger login when pressing Enter
    document.getElementById("login-form").addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();  // Prevent form from submitting
            handleLogin();  // Call the login function
        }
    });
    
    // Remember Me logic for login form (auto-fill email and password if saved)
    if (localStorage.getItem("email")) {
        emailField.value = localStorage.getItem("email");
        passwordField.value = localStorage.getItem("password");
        rememberMeCheckbox.checked = true;
    }
    
    const forgotPasswordBtn = document.getElementById("forgot-password-btn");
    // Show the forgot password form when the button is clicked
    forgotPasswordBtn.addEventListener("click", function () {
        document.querySelector('.login-form').style.display = 'none'; // Hide the login form
        document.getElementById('forgot-password-form').style.display = 'block'; // Show the forgot password form
    });

    // Return to login form from the forgot password form
    document.getElementById('back-to-login-btn').addEventListener('click', function () {
        document.querySelector('.login-form').style.display = 'block'; // Show the login form
        document.getElementById('forgot-password-form').style.display = 'none'; // Hide the forgot password form
    });

    // Reset password functionality
    document.getElementById('reset-password-btn').addEventListener('click', function () {
        const email = document.getElementById('forgot-email').value;

        // Simple email validation
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Regex for validating an email address

        if (email && emailPattern.test(email)) {
            alert('A password reset link has been sent to your email.'); // For demonstration
            // Redirect to the login page (update with your actual login page URL)
            window.location.href = 'login.html'; // Change 'login.html' to your actual login page path
        } else {
            document.getElementById('forgot-email-error').textContent = 'Please enter a valid email address.';
        }
    });
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
        const signupPhoneField = document.getElementById("signup-phone-number");
        if (signupPhoneField.value.length !== 11) {
            allFilled = false;
            signupPhoneField.style.borderColor = "red"; // Highlight invalid phone number
            signupPhoneErrorMsg.textContent = "Please enter a valid 11-digit phone number."; // Set error message
        } else {
            signupPhoneField.style.borderColor = ""; // Reset border color if valid
        }

        // Validate password field (Check if it's filled)
        const signupPasswordErrorMsg = document.getElementById("signup-password-error");
        const signupPasswordField = document.getElementById("signup-password");
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

    document.getElementById("signup-btn").addEventListener("click", async function(event) {
        event.preventDefault(); // Prevent form submission if needed
                  
        const formData = new FormData();

        formData.append("first_name", document.getElementById("first-name").value);
        formData.append("last_name", document.getElementById("last-name").value);
        formData.append("contact_number", document.getElementById("signup-phone-number").value);
        formData.append("address", document.getElementById("address").value);
        formData.append("email_address", document.getElementById("email").value);
        formData.append("password", document.getElementById("signup-password").value);
        
        const idFrontFile = document.getElementById("id-front").files[0];
        if (idFrontFile) {
            formData.append("id_front", idFrontFile);
        }
        
        const idBackFile = document.getElementById("id-back").files[0];
        if (idBackFile) {
            formData.append("id_back", idBackFile);
        }
      
        try {
            const response = await fetch('/backend/src/customer/route.php?route=customer/signup', {
                method: 'POST', // Use POST method
                body: formData // Send the FormData object as the request body
            });

            // Check if the response is okay
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            // Parse the JSON response
            const responseData = await response.json();
            
            // Log the response data or handle it as needed
            console.log('Response:', responseData);
        } catch (error) {
            console.error('Error during fetch:', error);
        }
            
    });
    

    const signupPhoneField = document.getElementById("signup-phone-number");
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
    // Show the forgot password form when the button is clicked
    document.getElementById('forgot-password-btn').addEventListener('click', function () {
    document.querySelector('.login-form').style.display = 'none'; // Hide the login form
    document.getElementById('forgot-password-form').style.display = 'block'; // Show the forgot password form
});

// Return to login form from the forgot password form
    document.getElementById('back-to-login-btn').addEventListener('click', function () {
    document.querySelector('.login-form').style.display = 'block'; // Show the login form
    document.getElementById('forgot-password-form').style.display = 'none'; // Hide the forgot password form
});

// Reset password functionality
    document.getElementById('reset-password-btn').addEventListener('click', function () {
    const email = document.getElementById('forgot-email').value;

    // Simple email validation
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Regex for validating an email address

    if (email && emailPattern.test(email)) {
        alert('A password reset link has been sent to your email.'); // For demonstration
        // Redirect to the login page (update with your actual login page URL)
        window.location.href = 'login.html'; // Change 'login.html' to your actual login page path
    } else {
        document.getElementById('forgot-email-error').textContent = 'Please enter a valid email address.';
    }
});
    document.getElementById('back-btn').addEventListener('click', function() {
    document.getElementById('signup-step-2').style.display = 'none';
    document.getElementById('signup-step-1').style.display = 'flex';
});



// Get the modal and close button
var modal = document.getElementById("productDetailsModal");
var closeBtn = document.getElementById("closeModalBtn"); // Get the close button by ID
var modalAddToCartBtn = document.getElementById("modalAddToCartBtn");
var productImage = document.getElementById("productImage");
var productName = document.getElementById("productName");
var productPrice = document.getElementById("productPrice");
var productDescription = document.getElementById("productDescription");

// To track which products are added to the cart
var addedToCart = {};

// Initially ensure modal is hidden
modal.style.display = "none";

// Add event listeners to all product boxes to open modal
document.querySelectorAll('.product-box').forEach(item => {

    item.addEventListener('click', function(event) {
                        
        // Get product ID from the button
        var productId = this.querySelector('.add-to-cart-btn').getAttribute('data-product-id');

        // Prevent modal from opening if the product is already added to the cart
        if (addedToCart[productId]) {
            alert("This product is already in your cart.");
            var userId = localStorage.getItem("user_id")
            const data = new URLSearchParams({                
                customer_id: "3",
                items : JSON.stringify([
                    {
                        model_id: userId,
                        quantity: 2,
                        total: 1798
                    },
                    {
                        model_id: "2",
                        quantity: -1,
                        total: -799
                    }
                ])
                
            });

            // fetch('/backend/src/customer/route.php?route=customer/save/cart', {
            //     method: 'POST',
            //     body: data.toString(),
            //     headers: {
            //         'Content-Type': 'application/x-www-form-urlencoded'
            //     }
            //     })
            //     .then(response => {
            //         if (!response.ok) {
            //             throw new Error('Network response was not ok');
            //         }
            //         return response.json();
            //     })
            //     .then(data => {
            //         console.log(data);
            //     })
            //     .catch(error => {
            //         console.error('There was a problem with the fetch operation:', error);
            //     });

            return; // Don't show the modal if the product was already added
        }

        // Prevent click events from the "Add to Cart" button inside the product-box
        if (event.target.classList.contains('add-to-cart-btn')) {
            // If the "Add to Cart" button outside the modal is clicked, mark the product as added
            addedToCart[productId] = true;
            alert("Product has been added to the cart.");
            return; // Don't open the modal, just perform the add-to-cart action
        }

        // Extract product details from the clicked product
        var imgSrc = this.querySelector('img').src;
        var name = this.querySelector('h4').innerText;
        var price = this.querySelector('.price p').innerText;
        var description = "This is a detailed description for " + name; // Example description

        // Update modal with product details
        productImage.src = imgSrc;
        productName.innerText = name;
        productPrice.innerText = price;
        productDescription.innerText = description; // Set the product description
        
        // Show the modal and disable body scroll
        modal.style.display = "flex";
        document.body.classList.add("modal-open");

        // Store the product ID in the modal for later use
        modal.setAttribute('data-product-id', productId);
    });
});


// Close modal when the close button (X) is clicked
closeBtn.onclick = function() {
    modal.style.display = "none"; // Hide the modal
    document.body.classList.remove("modal-open"); // Remove the scroll lock
}

// Close the modal when clicking outside the modal content
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none"; // Hide the modal
        document.body.classList.remove("modal-open"); // Remove the scroll lock
    }
}

// Close the modal and mark product as added to cart when the "Add to Cart" button is clicked inside the modal
modalAddToCartBtn.onclick = function() {
    // Get the product ID from the modal
    var productId = modal.getAttribute('data-product-id');
    
    // Mark the product as added to cart
    addedToCart[productId] = true;

    // Close the modal
    modal.style.display = "none"; // Hide the modal
    document.body.classList.remove("modal-open"); // Remove the scroll lock

    // Perform the add to cart action here (logic can be added if needed)
    alert("Product has been added to the cart.");
}

