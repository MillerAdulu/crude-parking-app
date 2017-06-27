<?php
    if(isset($_SESSION["username"])){
        header("Location: MyProfile.php");
    }else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ufanisi Parking : Add User</title>
    <link rel="stylesheet" href="css/w3.min.css">
</head>
<body>
    <div class="w3-display-container">
        <form action="dynamic_data/AddUser.php" method="post" onsubmit="return formValidate()" class="w3-margin w3-display-middle" style="padding-top: 500px;">
            <h3 class="w3-center">Register</h3>
            <label class="w3-label">Username:</label>
            <input type="text" name="username" class="w3-input" required>
            <label class="w3-label">First Name:</label>
            <input type="text" name="firstName" class="w3-input" required>
            <label class="w3-label">Last Name:</label>
            <input type="text" name="lastName" class="w3-input" required>
            <label class="w3-label">Email:</label>
            <input type="email" name="userEmail" class="w3-input" required>
            <label class="w3-label">Phone Number:</label>
            <input type="text" name="phoneNumber" class="w3-input" required>
            <label class="w3-label">Password:</label>
            <input type="password" name="userPassword" class="w3-input" required>
            <label class="w3-label">Retype Password:</label>
            <input type="password" name="retypePassword" class="w3-input" required>
            <input type="submit" value="Register" class="w3-btn w3-margin w3-round-jumbo">
            <input type="reset" value="Cancel" class="w3-btn w3-margin w3-round-jumbo"><br>
            <a href="index.php" class="w3-margin w3-center">Go Back</a>
        </form>
    </div>
</body>
</html>
<script src="js/jquery.min.js"></script>
<script src="js/formvalidation.js"></script>
<?php } ?>