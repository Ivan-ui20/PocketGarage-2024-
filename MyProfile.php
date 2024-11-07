<?php
    require_once './backend/database/db.php';
    session_start();

    if($_SESSION['user_id']) {
        header("index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- CSS-link -->
    <link rel="stylesheet" href="MyProfile.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
</head>
<body>
    <?php include './shared/header.php';?>

    <div class="profile-container">
        <h2>User Profile</h2>

        <div class="profile-content">
            <?php                
                $getData = $conn->prepare("SELECT 
                    CONCAT(customer.first_name, ' ', customer.last_name) AS name,
                    customer.contact_number,
                    customer.address,
                    customer.email_address,
                    customer.avatar
                FROM customer
                WHERE customer_id = ?");
                $getData->bind_param("s", $_SESSION['user_id']);
                $getData->execute();
                
                $result = $getData->get_result();
                $userData = $result->fetch_assoc();

                $avatar = !empty($userData['avatar']) ? 'http://localhost:3000/backend/' . $userData['avatar'] : '';
                $getData->close();
                
            ?>

            <!-- Profile Details Form with pre-filled values -->
            <form method="POST" enctype="multipart/form-data" class="profile-form">
                <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                <label for="fullname">Full Name</label>
                <input type="text" id="fullname" name="fullname" value="<?php echo $userData['name']; ?>" placeholder="Enter your full name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userData['email_address']); ?>" placeholder="Enter your email" required>

                <label for="phone">Mobile Number</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($userData['contact_number']); ?>" placeholder="Enter your phone number" pattern="[0-9]*" maxlength="11" required oninput="this.value = this.value.replace(/[^0-9]/g, '');">

                <label for="address">Address</label>
                <input id="address" name="address" value="<?php echo htmlspecialchars($userData['address']); ?>" placeholder="Enter your address" required>

                <div class="save-button-container">
                    <button type="submit" class="save-btn">Save</button> 
                </div>
            </form>


            
            <!-- Profile Picture on the Right -->
            <div class="profile-pic-save-container">
                <div class="profile-pic-container">
                    <div class="user-img">
                        <img src="<?php echo $avatar; ?>" id="photo" alt="Profile Picture">            
                        <input type="file" id="file">
                        <label for="file" id="uploadbtn"><i class="fas fa-camera"></i></label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Modal -->
    <?php include './shared/cartModal.php';?>
    <!-- Checkout Modal -->
    <?php include './shared/checkoutModal.php';?>

    <div class="footer">
        <?php include './shared/footer.php';?>
    </div>

    <?php include './shared/userAgreementModal.php';?>

    <script>
        let imageChanged = false;
        document.querySelector('.profile-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission so we can process the data

            // Confirm whether the user wants to save changes
            // if (!confirm("Do you want to save the changes?")) {
            //     return; // If the user cancels, stop the submission
            // }

            // Collect form data
            const form = document.querySelector('.profile-form');
            const formData = new FormData(form); // Collect data from the form

            // Check if an image is uploaded and append it to formData
            const fileInput = document.querySelector('#file');
            const chosenFile = fileInput.files[0];
            
            
            formData.append('avatar', chosenFile);
            formData.append('image_edited', imageChanged);
            
            fetch('/backend/src/customer/route.php?route=customer/profile', {
                method: 'POST',
                body: formData,          
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log(data);              
                alert("profile edited")
                document.getElementsByClassName('profile-form').reset();
                imageChanged = false;
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
        });



        const imgDiv = document.querySelector('.user-img');
        const img = document.querySelector('#photo');
        const file = document.querySelector('#file');

        file.addEventListener('change', function(){
            const chosenFile = this.files[0];
            if (chosenFile){
                const reader = new FileReader();
                reader.addEventListener('load', function(){ 
                    img.setAttribute('src', reader.result);
                });
                reader.readAsDataURL(chosenFile);
                imageChanged = true;
            }
        });
    </script>

    <script src="./scripts/getProduct.js"></script>
    <script src="./scripts/java.js"></script>
</body>
</html>
