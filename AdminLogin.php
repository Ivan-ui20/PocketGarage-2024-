<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="SellerLogin.css">
    <link rel="stylesheet" href="./css/Login.css">
</head>

<body>
    <div class="bg-container">
        <div class="inner-container">
            <div class="box login-form">
                <h1>Login as a Admin</h1>
                <form id="login-form">
                <input 
                      type="text" 
                      id="username" 
                      name="username" 
                      placeholder="Username" 
                      required 
                      maxlength="20" 
                      pattern="^[a-zA-Z0-9_]+$" 
                      oninput="validateUsername()" 
                  />
                  <span class="error-message" id="username-error"></span>
            
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

            <!-- <div class="box signup-form" id="signup-form">
                <h1>Sign Up as a Admin</h1>
                <form id="signup-step-1">
                
                <input 
                    type="text" 
                    id="signup-username" 
                    name="username" 
                    placeholder="Username" 
                    required 
                    maxlength="20" 
                    pattern="^[a-zA-Z0-9_]+$" 
                    oninput="validateUsername()" 
                />
                <span class="error-message" id="signup-username-error"></span>
                
                    <div class="name-fields">
                        <input type="text" id="first-name" name="first-name" placeholder="First Name" required />
                        
                    
                        <input type="text" id="last-name" name="last-name" placeholder="Last Name" required />
                       
                    </div>

                   
                    
                    <input type="password" id="signup-password" name="password" placeholder="Password" required />
                    <span class="error-message" id="signup-password-error"></span>
                    
                </form>
      
                <p>Already a member? <span id="login-link">Login</span></p>
            </div> -->

        </div>
    </div>
    <script src="./scripts/adminlogin.js"></script>
</body>
</html>