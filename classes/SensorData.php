<?php

    require_once "Connection.php";

/**
 * Class SensorData
 */
class SensorData extends Connection{

    /**
     *
     */
    function receiveData(){
            $position = $_GET["position"];
            $availability  = $_GET["availability"];
            $this->saveData($position, $availability);
        }

    /**
     * @param $parkSpot
     * @param $availability
     */
    function saveData($parkSpot, $availability){
            $masterConn = $GLOBALS['masterConn'];
            $sql = "UPDATE parkinglot_monitor SET availability = ? WHERE parkSpot = ?";
                if($stmt = $masterConn->prepare($sql)){
                    $stmt->bind_param("ii", $availability, $parkSpot);
                    $stmt->execute();
                    $masterConn->close();
                }else{
                    $masterConn->error;
                }
        }

    /**
     * @return mixed
     */
    function retrieveData(){
            $logConn = $GLOBALS["logConn"];
            $sql = "SELECT parkSpot FROM parkinglot_monitor WHERE availability = 1 ORDER BY parkSpot ASC LIMIT 1";
                if( $stmt = $logConn->prepare($sql)){
                    $stmt->execute();
                    return $stmt->get_result();
                }else
                    echo $logConn->error;
        }
    }
