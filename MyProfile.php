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
</head>
<body>
<?php include './shared/header.php';?>

<div class="profile-container">
    <h2>User Profile</h2>

    <!-- Flex container to align profile picture and form -->
    <div class="profile-content">
        <!-- Profile Details Form on the Left -->
        <form action="save_profile.php" method="POST" enctype="multipart/form-data" class="profile-form" onsubmit="return confirmSave()">
            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" pattern="[0-9]*" maxlength="11" required oninput="this.value = this.value.replace(/[^0-9]/g, '');">

            <label for="address">Address</label>
            <input id="address" name="address" placeholder="Enter your address" required>
        </form>

        <!-- Profile Picture -->
        <div class="profile-pic-save-container">
            <div class="profile-pic-container">
                <h3>Upload Profile Picture (1x1 size)</h3>
                <div class="user-img">
                  <img src="Default_pfp.svg.webp" id="photo">
                <input type="file" id="file">
                <label for="file" id="uploadbtn"><i class="fas fa-camera"></i></label>
                </div>
            </div>
        </div>

            <div class="save-button-container">
                <button type="submit" form="profile-form" class="save-btn">Save</button> 
            </div>
        </div>
    </div>
</div>

<div class="footer">
    <?php include './shared/footer.php';?>
</div>

<?php include './shared/userAgreementModal.php';?>

<script>
    function confirmSave() {
        return confirm("Do you want to save the changes?");
    }

const imgDiv = document.querySelector('.user-img');
const img = document.querySelector('#photo');
const file = document.querySelector('#file');
const uploadebtn = document.querySelector('#uploadbtn');

file.addEventListener( 'change', function(){
const chosedfile = this.files[0];
if (chosedfile){
  const reader = new FileReader();

reader.addEventListener('load' , function(){ 
  img.setAttribute('src', reader.result); });

reader.readAsDataURL(chosedfile);

};

})
</script>

</body>
</html>
