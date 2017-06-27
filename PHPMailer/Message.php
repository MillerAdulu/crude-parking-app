<?php
/**
 * Created by PhpStorm.
 * User: Adulu Miller
 * Date: 6/27/2017
 * Time: 22:15
 */

    require_once "PHPMailerAutoload.php";

    $contactEmail = $_POST["contactEmail"];
    $contactName = $_POST["contactName"];
    $contactSubject = $_POST["contactSubject"];
    $contactMessage = $_POST["contactMessage"];

    $mail = new PHPMailer;

    $mail->setFrom($contactEmail, "Ufanisi Parking");
    $mail->addAddress("milleradulu@gmail.com", "Miller Adulu");
    $mail->isHTML(true);
    $mail->Subject = $contactSubject;
    $mail->Body = $contactMessage;

        if(!$mail->send()){
            echo "Mail Error: " . $mail->ErrorInfo;
        }else{
            header("Location: ../index.php");
        }