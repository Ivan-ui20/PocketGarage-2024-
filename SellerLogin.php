<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SellerLogin&Signup</title>
    <link rel="stylesheet" href="SellerLogin.css">
</head>

<body>
    <div class="bg-container">
        <div class="inner-container">
            <div class="box login-form">
                <h1>Login as a Seller</h1>
                <form id="login-form">
                    <input type="text" id="phone-number" name="phone-number" placeholder="Phone Number" required maxlength="11" pattern="\d{11}" />
                    <span class="error-message" id="phone-error"></span>
            
                    <input type="password" id="password" name="password" placeholder="Password" required />
                    <span class="error-message" id="password-error"></span>
            
                    <div class="remember-me-container">
                        <input type="checkbox" id="remember-me" name="remember-me" />
                        <label for="remember-me" style="color: #fff;">Remember Me</label>
                    </div>
            
                    <button type="button" id="login-btn">LOGIN</button>
                    
                    <!-- Forgot Password Button -->
                    <button id="forgot-password-btn" class="forgot-password-button">Forgot Password?</button>
                </form>
            
                <p>Not a member? <span id="signup-link">Sign Up</span></p>

                <p>
                    By logging in, you agree to our 
                    <a href="terms-and-conditions.html" style="color: rgb(255, 0, 0);">Terms and Conditions</a>.
                </p>
            </div>
            
            <!-- Forgot Password Form -->
            <div class="box forgot-password-form" id="forgot-password-form" style="display:none;">
                <h1>Forgot Password</h1>
                <form id="forgot-password-step">
                    <input type="email" id="forgot-email" name="email" placeholder="Enter Your Email" required />
                    <span class="error-message" id="forgot-email-error"></span>
            
                    <button type="button" id="reset-password-btn">Reset Password</button>
                    <button type="button" id="back-to-login-btn">Back</button>
                </form>    
            </div>

            <div class="box signup-form" id="signup-form">
                <h1>Sign Up as a Seller</h1>
                <form id="signup-step-1">
                    <div class="name-fields">
                        <input type="text" id="first-name" name="first-name" placeholder="First Name" required />
                        <span class="error-message" id="first-name-error"></span>
                    
                        <input type="text" id="last-name" name="last-name" placeholder="Last Name" required />
                        <span class="error-message" id="last-name-error"></span>
                    </div>

                    <input type="text" id="email" name="email" placeholder="Email" required />
                    <span class="error-message" id="email-error"></span>
            
                    <input type="text" id="signup-phone-number" name="phone-number" placeholder="Phone Number" required maxlength="11" pattern="\d{11}" />
                    <span class="error-message" id="signup-phone-number-error"></span>
                    
                    <input type="password" id="signup-password" name="password" placeholder="Password" required />
                    <span class="error-message" id="signup-password-error"></span>

                    <label id="proof" for="Proof">Proof of past Trasnsaction (Seller):</label>
                    <input type="file" id="Proof" name="Proof" accept="image/*" required />
                    
                    <div class="signup-button-container">
                        <button type="submit" id="signup-btn">Sign Up</button>
                    </div>
                </form>

                <p>Already a member? <span id="login-link">Login</span></p>
            </div>

        </div>
    </div>
    <script src="./scripts/login.js"></script>
</body>
</html>