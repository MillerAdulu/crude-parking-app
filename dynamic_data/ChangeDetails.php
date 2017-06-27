<?php
    session_start();
    require_once "../classes/User.php";
    $change = new User;

    $change->sanitizeInput($username = $_SESSION["username"]);
    $change->sanitizeInput($firstName = $_POST["firstName"]);
    $change->sanitizeInput($lastName = $_POST["lastName"]);
    $change->sanitizeInput($email = $_POST["email"]);

    if(!$change->updateUser($username, $firstName, $lastName, $email)){
        die("Failed to update records. Please try again later.");
    }else{
        header("Location: ../MyProfile.php");
    }