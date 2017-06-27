<?php

    require_once "Constants.php";

/**
 * Class Connection
 */
class Connection{

    /**
     * @param $SERVER
     * @param $USER
     * @param $PASSWORD
     * @param $DB
     * @return mysqli
     */
    function connect($SERVER, $USER, $PASSWORD, $DB){
            $mysqli = mysqli_connect($SERVER, $USER, $PASSWORD, $DB);
                if($mysqli->connect_error)
                    die("Connection Failed: " . $mysqli->connect_error );
            return $mysqli;
        }

    /**
     * @param $connection
     */
    function killConn($connection){
            $connection->close();
        }

    }

    $master = new Connection;
    $masterConn = $master->connect(SERVER, USER, PASSWORD, DB);
    $user = new Connection;
    $userConn = $user->connect(SERVER, USER, PASSWORD, DB);
    $logConn = new Connection;
    $logConn = $user->connect(SERVER, USER, PASSWORD, DB);

    $driver = new mysqli_driver();
    $driver->report_mode = MYSQLI_REPORT_STRICT;
    date_default_timezone_set("Africa/Nairobi");
    $currentTime = date("His");