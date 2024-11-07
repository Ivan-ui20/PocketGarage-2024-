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

            const currentPath = window.location.pathname;

            let url;
            let type;
            if (currentPath.includes("SellerLogin.php")) {
                url = "/backend/src/seller/route.php?route=seller/login";
                type = 'seller';
            } else if (currentPath.includes("Login.php")) {
                url = "/backend/src/customer/route.php?route=customer/login";
                type = 'buyer';
            }
            
            fetch(url, {
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
                            alert(data.message)
                        } else {
                                                                      
                            if (rememberMeCheckbox.checked) {
                                localStorage.setItem("phone-number", phoneNumber);
                                localStorage.setItem("password", password);
                            } else {
                                localStorage.removeItem("phone-number");
                                localStorage.removeItem("password");
                            }

                            if(type === "seller") {
                                sessionStorage.setItem("sellerId", data.data.seller_id)
                                alert("login success")
                                // Redirect to index.html
                                window.location.href = 'seller.php';
                            } else {
                                sessionStorage.setItem("userId", data.data.user_id)
                                alert("login success")
                                // Redirect to index.html
                                window.location.href = 'index.php';
                            }
                           

                            
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

if (nextBtn){
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
}


// Back button functionality for sign-up form
const backBtn = document.getElementById("back-btn");

if (backBtn){
    backBtn.addEventListener("click", function() {
        signupStep2.style.display = "none"; // Hide step 2
        signupStep1.style.display = "block"; // Show step 1
    });
}

document.getElementById("signup-btn").addEventListener("click", async function(event) {
    console.log('yo');
    
    event.preventDefault(); // Prevent form submission if needed
              
    const formData = new FormData();

    formData.append("first_name", document.getElementById("first-name").value);
    formData.append("last_name", document.getElementById("last-name").value);
    formData.append("contact_number", document.getElementById("signup-phone-number").value);
    formData.append("address", document.getElementById("address") ? document.getElementById("address").value : "");
    formData.append("email_address", document.getElementById("email").value);
    formData.append("password", document.getElementById("signup-password").value);
    
    const idFrontFile = document.getElementById("id-front");
    if (idFrontFile) {
        formData.append("id_front", idFrontFile.files[0]);
    }
    
    const idBackFile = document.getElementById("id-back");
    if (idBackFile) {
        formData.append("id_back", idBackFile.files[0]);
    }

    const proofSeller = document.getElementById("Proof");
    if (proofSeller) {
        formData.append("proof", proofSeller.files[0]);
    }
    
    const currentPath = window.location.pathname;
    let url;    
    if (currentPath.includes("SellerLogin.php")) {
        url = "/backend/src/seller/route.php?route=seller/signup";        
    } else if (currentPath.includes("Login.php")) {
        url = "/backend/src/customer/route.php?route=customer/signup";        
    }
    
    try {
        const response = await fetch(url, {
            method: 'POST', // Use POST method
            body: formData // Send the FormData object as the request body
        });

        // Check if the response is okay
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        // Parse the JSON response
        const responseData = await response.json();
        
        if (responseData.success === "Failed") {
            alert(responseData.message)
        } else {
            alert("Success")
        }

        window.location.reload();
        
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

if(backBtn){
    backBtn.addEventListener('click', function() {
        document.getElementById('signup-step-2').style.display = 'none';
        document.getElementById('signup-step-1').style.display = 'flex';
    });
}

document.getElementById("signup-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission to allow custom behavior

    // Assuming validation is successful, simulate a successful signup
    const isSignupSuccessful = true; // Replace with actual validation logic if necessary

    if (isSignupSuccessful) {
        // Show success message
        alert("Signup successful! Redirecting to login...");

        // Redirect to the login form after 2 seconds
        setTimeout(() => {
            // Hide signup form and show login form
            document.querySelector(".signup-form").style.display = "none";
            document.querySelector(".login-form").style.display = "block";
        }, 2000);
    } else {
        // Display an error message if signup failed (optional)
        alert("Signup failed. Please check your inputs and try again.");
    }
});