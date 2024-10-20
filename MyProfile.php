<?php
// Initialize variables for the profile data
$fullname = $email = $phone = $address = $gender = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);
    $gender = htmlspecialchars($_POST['gender']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>User Profile</h1>
        <form id="profileForm" method="post" action="">
            <div class="form-group">
                <label for="fullname">Full Name:</label>
                <input type="text" id="fullname" name="fullname" value="<?php echo $fullname; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo $address; ?>" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="" <?php echo ($gender == "") ? "selected" : ""; ?>>Select...</option>
                    <option value="male" <?php echo ($gender == "male") ? "selected" : ""; ?>>Male</option>
                    <option value="female" <?php echo ($gender == "female") ? "selected" : ""; ?>>Female</option>
                    <option value="other" <?php echo ($gender == "other") ? "selected" : ""; ?>>Other</option>
                </select>
            </div>
            <button type="submit">Save Changes</button>
        </form>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <div class="profile-data">
                <h2>Your Profile Data</h2>
                <p><strong>Full Name:</strong> <?php echo $fullname; ?></p>
                <p><strong>Email:</strong> <?php echo $email; ?></p>
                <p><strong>Phone Number:</strong> <?php echo $phone; ?></p>
                <p><strong>Address:</strong> <?php echo $address; ?></p>
                <p><strong>Gender:</strong> <?php echo $gender; ?></p>
            </div>
        <?php endif; ?>
    </div>
    <script src="script.js"></script>
</body>
</html>