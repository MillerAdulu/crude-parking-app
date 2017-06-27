<?php
    session_start();
    if(isset($_SESSION["username"])){
        header("Location: MyProfile.php");
    }else{
        require_once 'classes/SessionManagement.php';
        $error = new SessionManagement;
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Ufanisi Parking System : Login</title>
        <link rel="stylesheet" href="css/w3.min.css">
    </head>
    <body class="w3-container w3-display-container w3-light-grey">
            <form name="loginForm" action="<?php echo htmlentities("dynamic_data/ValidateLogin.php"); ?>" method="post" onsubmit="return formValidate()" class="w3-display-middle w3-border w3-round-large w3-padding" style="margin-top: 250px">
                <span class="w3-tag w3-blue"><?php
                    if(isset($_SESSION["errors"])){
                        echo $_SESSION["errors"];
                        unset($_SESSION["errors"]);
                    }
                        ?></span><br>
                <label class="w3-label">Username</label>
                <input type="text" name="username" class="w3-input w3-hover-blue" required><br>
                <label class="w3-label">Password</label>
                <input type="password" name="password" class="w3-input w3-hover-blue" required><br>
                <div class="w3-center"><input type="submit" value="Login" class="w3-btn w3-round-jumbo w3-indigo">
                <input type="reset" value="Cancel" class="w3-btn w3-round-jumbo w3-indigo">
                    <p><a href="AddUser.php" class="w3-text-green">Don't have an account?</a></p>
                    <p><a href="index.php" class="w3-text-green">Go Back</a></p>
                </div>
            </form>

    <script>
        document.addEventListener("DOMContentLoaded", function(){
            // Handler when the DOM is fully loaded
            function formValidate(){
                var username = document.forms["loginForm"]["username"].value;
                var password = document.forms["loginForm"]["password"].value;

                    if(username === "" || password === ""){
                        alert("Ensure your username and password is not empty");
                        return false;
                    }
            }
        });
    </script>
    </body>
    </html>
<?php } ?>