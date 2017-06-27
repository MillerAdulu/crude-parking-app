<?php

require_once "Connection.php";

/**
 * Class Payment
 */
class Payment{
    /**
     * @var $userId
     */
    /**
     * @var $paymentMethod
     */
    /**
     * @var $cardNumber
     */
    /**
     * @var $phoneNumber
     */
    /**
     * @var $amount
     */
    /**
     * @var $receiptId
     */
    protected   $userId,
                $paymentMethod,
                $cardNumber,
                $phoneNumber,
                $amount,
                $receiptId;

    /**
     * @param $userId
     */
    function setUserId($userId){
        $this->userId = $userId;
    }

    /**
     * @param $paymentMethod
     */
    function setPaymentMethod($paymentMethod){
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * @param $amount
     */
    function setAmount($amount){
        $this->amount = $amount;
    }

    /**
     * @param $bookId
     */
    function setReceiptId($bookId){
        $receiptId = $this->loadBookings($bookId);
        $this->receiptId = $receiptId;
    }

    /**
     * @param $username
     */
    function setCardNumber($username){
        $this->cardNumber = $this->loadCard($username);
    }

    /**
     * @param $username
     */
    function setPhoneNumber($username){
        $this->phoneNumber = $this->loadPhone($username);
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
    function getPaymentMethod(){
        return $this->paymentMethod;
    }

    /**
     * @return mixed
     */
    function getAmount(){
        return $this->amount;
    }

    /**
     * @return mixed
     */
    function getReceiptId(){
        return $this->receiptId;
    }

    /**
     * @return mixed
     */
    function getCardNumber(){
        return $this->cardNumber;
    }

    /**
     * @return mixed
     */
    function getPhoneNumber(){
        return $this->phoneNumber;
    }

    /**
     * @param $receiptId
     * @return mixed
     */
    function uniquePayment($receiptId){
        $userConn = $GLOBALS["userConn"];
        $sql = "SELECT * FROM payments WHERE receiptId = ?";
        if($stmt = $userConn->prepare($sql)){
            $stmt->bind_param("s", $receiptId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->num_rows;
        }else
            echo "Unable to query" . $userConn->error;
    }

    /**
     * @param $userId
     * @param $receiptId
     * @param $paymentMethod
     * @param $phoneNumber
     * @param $amount
     */
    function pay($userId, $receiptId, $paymentMethod, $phoneNumber, $amount){
        $rowCount = $this->uniquePayment($receiptId);
        if($rowCount === 0){
                $logConn = $GLOBALS["logConn"];
                $sql = "INSERT INTO payments(userId, receiptId, payMethod, phoneNumber, amountPaid) VALUES(?, ?, ?, ?, ?)";
                    if($stmt = $logConn->prepare($sql)){
                        $stmt->bind_param("isisi", $userId, $receiptId, $paymentMethod, $phoneNumber, $amount);
                        $stmt->execute();
                        require_once "Booking.php";
                        $updateStatus = new Booking;
                        $updateStatus->updateStatus($receiptId);
                        header("Location: ../MyProfile.php");
                    }else
                        echo "Failed to prepare this statement";
            }
            die("This payment has been made");
        }

    /**
     * @param $bookId
     * @return mixed
     */
    function loadBookings($bookId){
        $userConn = $GLOBALS["userConn"];
        $sql = "SELECT receiptId FROM bookings WHERE bookId = ?";
        if($stmt = $userConn->prepare($sql)){
            $stmt->bind_param("i", $bookId);
            $stmt->execute();
            $result = $stmt->get_result();
            $result = $result->fetch_assoc();
            return $result["receiptId"];
        }
        $userConn->close();
    }

    /**
     * @param $userId
     * @return mixed
     */
    function loadPhone($userId){
        $userConn = $GLOBALS["userConn"];
        $sql = "SELECT phoneNumber FROM users WHERE userId = ?";
        if($stmt = $userConn->prepare($sql)){
            $stmt->bind_param("s", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $result = $result->fetch_assoc();
            return $result["phoneNumber"];
        }
        $userConn->close();
    }

    /**
     * @param $receiptId
     * @return int
     */
    function getCharges($receiptId){
        /*
         * Ufanisi Rates
         * 1 hr = 50 KES        Also least payable
         * 2 - 3 hrs = + 40 KES each
         * 4 - 5 hrs = + 30 KES each
         * 6 - 7 hrs = + 20 KES each
         * 8 - 9 hrs = + 10 KES each
         * */
        $timeDifference = $this->timeDifference($this->getTimeIn($receiptId), $this->getTimeOut($receiptId));
        $charges = $this->calculateRates($timeDifference);
        return $charges;

    }

    /**
     * @param $receiptId
     * @return mixed
     */
    function getTimeIn($receiptId){
        $userConn = $GLOBALS["userConn"];
        $sql = "SELECT timeIn FROM bookings WHERE receiptId = ?";
            if($stmt = $userConn->prepare($sql)){
                $stmt->bind_param("s", $receiptId);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                return $row["timeIn"];
            }
    }

    /**
     * @param $receiptId
     * @return mixed
     */
    function getTimeOut($receiptId){
        $userConn = $GLOBALS["userConn"];
        $sql = "SELECT timeOut FROM bookings WHERE receiptId = ?";
        if($stmt = $userConn->prepare($sql)){
            $stmt->bind_param("s", $receiptId);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return $row["timeOut"];
        }
    }

    /**
     * @param $timeIn
     * @param $timeOut
     * @return int
     */
    function timeDifference($timeIn, $timeOut){
        $timeIn = new DateTime($timeIn);
        $timeOut = new DateTime($timeOut);
        $timeDifference = date_diff($timeIn, $timeOut);
        return $hourDifference =  $timeDifference->i > 30 ? $timeDifference->h + 1 : $timeDifference->h;
    }

    /**
     * @param $timeDifference
     * @return int
     */
    function calculateRates($timeDifference){
        $charges = 50;
        if($timeDifference == 1)
            return $charges;
        return $charges;
    }
}