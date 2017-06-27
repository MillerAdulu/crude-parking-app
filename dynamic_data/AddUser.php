<?php
    if(file_exists("../classes/User.php"))
        require_once "../classes/User.php";
    else
        die("A required file doesn't exist. Please contact the administrator to report this issue");

    if(isset($_POST) && isset($_POST["username"]) && isset($_POST["userEmail"])){
        $username = $_POST["username"];
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $userEmail = $_POST["userEmail"];
        $phoneNumber = $_POST["phoneNumber"];
        $userPassword = password_hash($_POST["userPassword"], PASSWORD_DEFAULT);

        $addUser = new User;
        $addUser->setUsername($username);
        $addUser->setFName($firstName);
        $addUser->setLName($lastName);
        $addUser->setEmail($userEmail);
        $addUser->setPassword($userPassword);
        $addUser->setPhoneNumber($phoneNumber);
        $username = $addUser->getUsername();
        $firstName = $addUser->getFName();
        $lastName = $addUser->getLName();
        $userEmail = $addUser->getEmail();
        $phoneNumber = $addUser->getPhoneNumber();
        $userPassword = $addUser->getPassword();

            if($addUser->addUser($username,$firstName,$lastName,$userEmail, $userPassword, $phoneNumber))
                echo "User" . $username . " added successfully";
            else
                die("Failed to add user. Error: " . $masterConn->error);
    }
    else
        header("Location: ../AddUser.php");