<?php
    require_once "../classes/SessionManagement.php";
    $user = $GLOBALS["user"];
    $login = new SessionManagement;

    if(isset($_POST) && isset($_POST["username"]) && isset($_POST["password"])){
        $user->sanitizeInput($username = $_POST["username"]);
        $user->sanitizeInput($password = $_POST["password"]);

            $login->login($username, $password);

        }