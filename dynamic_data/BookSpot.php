<?php
    require_once  "../classes/Booking.php";

    session_start();
    $userId = $_SESSION["userId"];
    $parkSpot = $_POST["position"];
    $bookDate = $_POST["bookDate"];
    $timeIn = $_POST["timeIn"];
    $timeOut = $_POST["timeOut"];

    $book = new Booking;
    $book->bookSpot($userId, $bookDate, $timeIn, $timeOut, $parkSpot);
    header("Location: ../MyProfile.php");
