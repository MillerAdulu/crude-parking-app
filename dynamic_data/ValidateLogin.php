<?php
    require_once "../classes/SessionManagement.php";

    if(isset($_POST) && isset($_POST["username"]) && isset($_POST["password"])){
        $username = $_POST["username"];
        $password = $_POST["password"];

            $login = new SessionManagement;
            $login->login($username, $password);

        }