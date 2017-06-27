<?php
/**
 * Class Booking
 */
require_once "Connection.php";

/**
 * Class Booking
 */
class Booking{
    /**
     * @var $userId
     */
    /**
     * @var $bookDate
     */
    /**
     * @var $timeIn
     */
    /**
     * @var $timeOut
     */
    /**
     * @var $parkSpot
     */
    /**
     * @var $receiptId
     */
    /**
     * @var $fine
     */
    public      $userId,      //Session Username
                    $bookDate,          //System Date
                    $timeIn,        //
                    $timeOut,
                    $parkSpot,      //Booked parking spot
                    $receiptId,     //Unique receipt id
                    $fine;

    /**
     * @return mixed
     */
    public function getBookDate()
    {
        return $this->bookDate;
    }

    /**
     * @param mixed $bookDate
     */
    function setBookDate($bookDate)
    {
        $this->bookDate = $bookDate;
    }          //Fine if applicable

    /**
     * @param $userId
     */
    function setUserId($userId){
            $this->userId = $userId;
        }

    /**
     * @param $parkSpot
     */
    function setParkSpot($parkSpot){
            $this->parkSpot = $parkSpot;
        }

    /**
     * @param $bookDate
     */
    function setDate($bookDate){
            $this->bookDate = date($bookDate, strtotime($bookDate));
        }

    /**
     * @param $timeIn
     */
    function setTimeIn($timeIn){
            $timeIn = $timeIn . ":00";
            $this->timeIn = date($timeIn, strtotime($timeIn));
        }

    /**
     * @param $timeOut
     */
    function setTimeOut($timeOut){
            $timeOut = $timeOut . ":00";
            $this->timeOut = date($timeOut, strtotime($timeOut));
        }

    /**
     * @param $fine
     */
    function setFine($fine){
            $this->fine = $fine;
        }

    /**
     *
     */
    function setReceiptId(){
            $receiptId = $this->parkSpot . $this->bookDate . $this->timeIn . $this->timeOut;
            $this->receiptId = md5($receiptId);
        }

    /**
     * @return mixed
     */
    function getUserId(){
            return $this->userId;
        }

    /**
     * @return mixed
     */
    function getParkSpot(){
            return $this->parkSpot;
        }

    /**
     * @return mixed
     */
    function getDate(){
            return $this->bookDate;
        }

    /**
     * @return mixed
     */
    function getTimeIn(){
            return $this->timeIn;
        }

    /**
     * @return mixed
     */
    function getTimeOut(){
            return $this->timeOut;
        }

    /**
     * @return mixed
     */
    function getFine(){
            return $this->fine;
        }

    /**
     * @return mixed
     */
    function getReceiptId(){
            return $this->receiptId;
        }

    /**
     * @param $userId
     * @param $bookDate
     * @param $timeIn
     * @param $timeOut
     * @param $parkSpot
     */
    function bookSpot($userId, $bookDate, $timeIn, $timeOut, $parkSpot){
            $this->setUserId($userId);
            $this->setParkSpot($parkSpot);
            $this->setDate($bookDate);
            $this->setTimeIn($timeIn);
            $this->setTimeOut($timeOut);
            $this->setReceiptId();
            $userId = $this->getUserId();
            $parkSpot = $this->getParkSpot();
            $bookDate = $this->getDate();
            $timeIn = $this->getTimeIn();
            $timeOut = $this->getTimeOut();
            $receiptId = $this->getReceiptId();
            $this->logBooking($userId, $bookDate, $timeIn, $timeOut, $parkSpot, $receiptId);
        }

    /**
     * @return false|string
     */
    function currentDate(){
            date_default_timezone_set("Africa/Nairobi");
            return date("Y-m-d");
        }

    /**
     * @param $time
     * @return false|string
     */
    function processTime($time){
            $timeString = $time.":00";
            return date($timeString, strtotime($timeString));
        }

    /**
     * @param $userId
     * @param $bookDate
     * @param $timeIn
     * @param $timeOut
     * @param $parkSpot
     * @param $receiptId
     */
    function logBooking($userId, $bookDate, $timeIn, $timeOut, $parkSpot, $receiptId){
            if(($rowCount = $this->bookingExistence($receiptId)) > 0){
                die("This booking has already been made");
            }else{
                $logConn = $GLOBALS["logConn"];
                $sql = "INSERT INTO bookings(userId, bookDate, timeIn, timeOut, parkSpot, receiptId) 
                VALUES (?, ?, ?, ?, ?, ?)";
                    if($stmt = $logConn->prepare($sql)){
                        $stmt->bind_param("ssssis", $userId, $bookDate, $timeIn, $timeOut, $parkSpot, $receiptId);
                        $stmt->execute();
                        $this->updateParkingLot($parkSpot);
                        }
                        else
                            echo "error";
                    }
            $logConn->close();
        }

    /**
     * @param $receiptId
     * @return mixed
     */
    function bookingExistence($receiptId){
            $userConn = $GLOBALS["userConn"];
            $sql = "SELECT * FROM bookings WHERE receiptId = ?";
                if($stmt = $userConn->prepare($sql)){
                $stmt->bind_param("s", $receiptId);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result->num_rows;
            }
        }

    /**
     * @param $date
     * @param $timeIn
     * @param $timeOut
     * @param $parkSpot
     * @param $paymentMethod
     * @param $amount
     * @param $receiptId
     */
    function updateBooking($date, $timeIn, $timeOut, $parkSpot, $paymentMethod, $amount, $receiptId){
            $rowCount = $this->bookingExistence($receiptId);

            if($rowCount == 1){
                $logConn = $GLOBALS["logConn"];
                $sql = "UPDATE bookings SET bookDate = ?, timeIn = ?, timeOut = ?, parkSpot = ?, paymentMethod = ?, amount = ?   WHERE receiptId = ?";
                    if($stmt = $logConn->prepare($sql)){
                        $stmt->bind_param("sssisis", $date, $timeIn, $timeOut, $parkSpot, $paymentMethod, $amount, $receiptId);
                        $stmt->execute();
                    }
            }
            $logConn->close();
        }

    /**
     * @param $receiptId
     */
    function updateStatus($receiptId){
            $logConn = $GLOBALS["logConn"];
            $sql = "UPDATE bookings SET paymentStatus = 1   WHERE receiptId = ?";
            if($stmt = $logConn->prepare($sql)){
                $stmt->bind_param("s", $receiptId);
                $stmt->execute();
            }
        $logConn->close();
        }

    /**
     * @param $receiptId
     */
    function cancelBooking($receiptId){
            $rowCount = $this->bookingExistence($receiptId);

            if($rowCount == 1){
                $logConn = $GLOBALS["logConn"];
                $sql = "UPDATE bookings SET paymentStatus = ?   WHERE receiptId = ?";
                    if($stmt = $logConn->prepare($sql)){
                        $status = 0;
                        $stmt->bind_param("is", $status, $receiptId);
                        $stmt->execute();
                    }else
                die("This booking doesn't exist!");
            }
            $logConn->close();
        }

    /**
     * @param $parkSpot
     */
    function updateParkingLot($parkSpot){
            require_once "SensorData.php";
            $updateLot = new SensorData;
            $updateLot->saveData($parkSpot, 0);
        }

    /**
     *
     */
    function loadSpots(){
            require_once "SensorData.php";
            $sense = new SensorData;

            $result = $sense->retrieveData();

                while ($row = $result->fetch_assoc()) {
                    echo  $row["parkSpot"] ;
                }
        }

    /**
     * @param $userId
     * @return mixed
     */
    function queryBookings($userId){
            try{
                $userConn = $GLOBALS["userConn"];
                $sql = "SELECT bookId, bookId, bookDate, timeIn, timeOut, parkSpot, receiptId, paymentStatus, bookTime FROM bookings WHERE userId = ? ORDER BY bookId DESC";
                if($stmt = $userConn->prepare($sql)){
                    $stmt->bind_param("s", $userId);
                    $stmt->execute();
                    return $stmt->get_result();
                }else
                    die("Error");
            }catch (Exception $e){
                echo $e;
            }

        }

    /**
     * @param $userId
     */
    function loadBookings($userId){

            try{
            $result = $this->queryBookings($userId);
            while ($row = $result->fetch_assoc()) {
                if($row["paymentStatus"] == 1){
                    $status = "PAID";
                    $id = null;
                }
                else {
                    $status = '<a href="dynamic_data/Pay.php?bookId='.$row["bookId"].'">Pay</a><span class="w3-badge w3-red">*</span>';
                    $id = "id = " . date("i", strtotime($row["bookTime"]));
                }
                echo '<tr>';
                echo '<td id="'. $row["bookId"].'"> '. $row["bookId"] .' </td>';
                echo '<td>'. $row["bookDate"] .'</td>';
                echo '<td>'. $row["timeIn"] .'</td>';
                echo '<td>'. $row["timeOut"] .'</td>';
                echo '<td>'. $row["parkSpot"] .'</td>';
                echo '<td>'. $row["receiptId"] .'</td>';
                echo '<td '.$id.'>'. $row["bookTime"].'</td>';
                echo '<td>'. $status .'</td>';
                echo '</tr>';
            }
            }catch(Exception $e){
                echo $e;
            }
        }

    /**
     * @param $userId
     * @return mixed
     */
    function getSpotStatus($userId){
            try{
                $result = $this->queryBookings($userId);
                $row = $result->fetch_assoc();
                return $row["paymentStatus"];
            }catch(Exception $e){
                echo $e;
            }
        }
    }