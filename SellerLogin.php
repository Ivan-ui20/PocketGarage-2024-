<?php    
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Signup</title>
    <link rel="stylesheet" href="SellerLogin.css">
    <link rel="stylesheet" href="./css/Login.css">
</head>

<body>
    <div class="bg-container">
        <div class="inner-container">
        <!-- <a href="index.php" id="close-btn-sellerL">x</a>            -->
            <div class="box signup-form" id="signup-form" style="display: flex;">
                <h1>Sign Up as a Seller</h1>
                <form id="signup-step-1">
                <button type="button" id="back-btn" class="back-btn">Back</button>
                    <label id="valid" for="id-front">Valid ID (Front):</label>
                    <input type="file" id="id-front" name="id-front" accept="image/*" required />
                    <label id="valid" for="id-back">Valid ID (Back):</label>
                    <input type="file" id="id-back" name="id-back" accept="image/*" required />
                    <label id="proofs" for="Proof">Proof of past Trasnsaction (Seller):</label>
                    <input type="file" id="Proof" name="Proof" accept="image/*" required />
                    
                    <div class="signup-button-container">
                        <button type="button" id="signup-btn">Sign Up</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <script>
        const customerId = "<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; ?>" || null;            
    </script>
    <script src="./scripts/login.js"></script>
</body>
</html>