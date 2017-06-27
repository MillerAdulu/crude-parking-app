<?php

require_once "../classes/SensorData.php";
require_once "../classes/Booking.php";
$sense = new SensorData;
$sense->receiveData();
header("Refresh: 3");