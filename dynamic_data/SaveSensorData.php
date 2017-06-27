<?php
    require_once "../classes/SensorData.php";
    require_once "../classes/Booking.php";
    $sense = new SensorData;
    $book = new Booking;

    $book->loadSpots();