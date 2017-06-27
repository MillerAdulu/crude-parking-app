<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: login.php");
}else{
    $userId = $_SESSION["userId"];
    $username = $_SESSION["username"];
    $firstName = $_SESSION["firstName"];
    $lastName = $_SESSION["lastName"];
    $email = $_SESSION["email"];
?>
    <!DOCTYPE html>
    <html>
        <head>
            <link href="css/w3.min.css" rel="stylesheet">
        </head>
        <body>
            <form action="<?php echo htmlentities("dynamic_data/ChangeDetails.php") ?>" method="post" class="w3-margin w3-display-middle w3-border-black">
                <label class="w3-label">First Name:</label>
                <input type="text" name="firstName" class="w3-input" value="<?php echo $firstName ?>" required>
                <label class="w3-label">Last Name:</label>
                <input type="text" name="lastName" class="w3-input" value="<?php echo $lastName ?>" required>
                <label class="w3-label">Email:</label>
                <input type="email" name="email" class="w3-input" value="<?php echo $email ?>" required>
                <input type="submit" value="Change" class="w3-btn w3-margin w3-round-jumbo">
                <a href="MyProfile.php" class="w3-btn w3-margin w3-round-jumbo">Cancel</a>
            </form>
        </body>
    </html>

<?php } ?>