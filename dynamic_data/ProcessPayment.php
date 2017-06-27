<?php
    require_once "../classes/Booking.php";
    require_once "../classes/Payment.php";

    session_start();
    $userId = $_SESSION["userId"];
    $payMethod = $_POST["paymentMethod"];
    $receiptId = $_POST["receiptId"];
    $phoneNumber = $_POST["phoneNumber"];
    $amount = $_POST["amount"];
    $finalizePay = new Payment;

    $finalizePay->pay($userId, $receiptId, $payMethod, $phoneNumber, $amount);

