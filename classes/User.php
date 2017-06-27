<?php

    require_once "Connection.php";

/**
 * Class User
 */
class User extends Connection{

    /**
     * @var $username
     */
    /**
     * @var $firstName
     */
    /**
     * @var $lastName
     */
    /**
     * @var $password
     */
    /**
     * @var $phoneNumber
     */
    /**
     * @var $email
     */
    /**
     * @var $userId
     */
    public  $userId,
                $username,       //Username
                $firstName,     // First name
                $lastName,      // Last name
                $password,       //Password
                $phoneNumber,   //Phone Number
                $email;          // Email

    /**
     * @param $userId
     */
    function setUserId($userId){
            $this->userId = $userId;
    }

    /**
     * @param $username
     */
    function setUsername($username){
            $this->username = $username;
        }

    /**
     * @param $first_name
     */
    function setFName($first_name){
            $this->firstName = $first_name;
        }

    /**
     * @param $last_name
     */
    function setLName($last_name){
            $this->lastName = $last_name;
        }

    /**
     * @param $password
     */
    function setPassword($password){
           $this->password = $password;
        }

    /**
     * @param $email
     */
    function setEmail($email){
            $this->email = $email;
        }

    /**
     * @param $phoneNumber
     */
    function setPhoneNumber($phoneNumber){
            $this->phoneNumber = $phoneNumber;
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
    function getUsername(){
            return $this->username;
        }

    /**
     * @return mixed
     */
    function getFName(){
            return $this->firstName;
        }

    /**
     * @return mixed
     */
    function getLName(){
            return $this->lastName;
        }

    /**
     * @return mixed
     */
    function getPassword(){
            return $this->password;
        }

    /**
     * @return mixed
     */
    function getEmail(){
            return $this->email;
        }

    /**
     * @return mixed
     */
    function getPhoneNumber(){
            return $this->phoneNumber;
        }

    /**
     * @param $email
     * @return mixed
     */
    function uniqueEmail($email){
            $userConn = $GLOBALS["userConn"];
            $sql = "SELECT email FROM users WHERE email = ?";

                if($stmt = $userConn->prepare($sql)){
                    $stmt->bind_param('s', $email);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    return $result->num_rows;
                }
            $this->killConn($userConn);
        }

    /**
     * @param $username
     * @return mixed
     */
    function uniqueUsername($username){
            $userConn = $GLOBALS["userConn"];
            $sql = "SELECT username FROM users WHERE username = ?";

            if($stmt = $userConn->prepare($sql)){
                $stmt->bind_param('s', $username);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result->num_rows;
            }
            $this->killConn($userConn);
        }

    /**
     * @param $phoneNumber
     * @return mixed
     */
    function uniquePhoneNumber($phoneNumber){
            $userConn = $GLOBALS["userConn"];
            $sql = "SELECT phoneNumber FROM users WHERE phone_number = ?";

            if($stmt = $userConn->prepare($sql)){
                $stmt->bind_param('s', $phoneNumber);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result->num_rows;
            }
            $this->killConn($userConn);
        }

    /**
     * @param $username
     * @param $FName
     * @param $LName
     * @param $email
     * @param $password
     * @param $phoneNumber
     */
    function addUser($username, $FName, $LName, $email, $password, $phoneNumber){
            $rowCount = $this->uniqueUsername($username);
            $emailCount = $this->uniqueEmail($email);
            $phoneCount = $this->uniquePhoneNumber($phoneNumber);

                if($rowCount != 0)
                    die("This user exists");
                else if($emailCount != 0)
                    die("A user with this email exists");
                else if($phoneCount != 0)
                    die("A user with this phone number exists");
                else{
                    $masterConn = $GLOBALS["masterConn"];
                    $sql = "INSERT INTO users(username, firstName, lastName, email, password, phoneNumber) VALUES (?, ?, ?, ?, ?, ?)";
                        if($stmt = $masterConn->prepare($sql)) {
                            $stmt->bind_param("ssssss", $username, $FName, $LName, $email, $password, $phoneNumber);
                            $stmt->execute();
                            header("Location: ../login.php");
                        }else{
                            die("This query was unable to execute: " . $stmt->error);
                        }
                }
                $this->killConn($masterConn);
        }

    /**
     * @param $username
     */
    function deleteUser($username){
            $rowCount = $this->userExistence($username);

                if($rowCount == 1){
                    $masterConn = $GLOBALS["masterConn"];
                    $sql = "DELETE FROM users WHERE username = ?";
                        if(!$stmt = $masterConn->prepare($sql)){
                            die("Unable to execute this query");
                        }else{
                            $stmt->bind_param("s", $username);
                            $stmt->execute();
                            $this->killConn($masterConn);
                        }
                    $this->killConn($masterConn);
                }
        }

    /**
     * @param $username
     * @param $FName
     * @param $LName
     * @param $email
     */
    function updateUser($username, $FName, $LName, $email){
            $rowCount = $this->uniqueUsername($username);

            if($rowCount == 1) {
                $masterConn = $GLOBALS["masterConn"];
                $sql = "UPDATE users SET firstName = ?, lastName = ?, email = ? WHERE username = ?";

                if($stmt = $masterConn->prepare($sql)){
                    $stmt->bind_param("ssss", $FName, $LName, $email, $username);
                    $stmt->execute();
                    $this->killConn($masterConn);
                }else{
                    $this->killConn($masterConn);
                    die("Cannot execute this command!");
                }
            }
        }
    function sanitizeInput($input){
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlentities($input);
        return $input;
    }
    }