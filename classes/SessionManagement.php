<?php

    require_once "Connection.php";
    require_once "User.php";
    $user = new User;

/**
 * Class SessionManagement
 */
class SessionManagement{
    /**
     * @param $errorMessage
     */
    function setErrors($errorMessage){
            session_start();
            $_SESSION["errors"] = $errorMessage;
        }

    /**
     * @param $username
     * @param $password
     */
    function login($username, $password){
            $user = $GLOBALS["user"];
            $rowCount = $user->uniqueUsername($username);

            if($rowCount == 1){
                $userConn = $GLOBALS["userConn"];
                $sql = "SELECT password FROM users WHERE username = ?";

                if($stmt = $userConn->prepare($sql)){
                    $stmt->bind_param('s', $username);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $this->matchPassword($row, $username, $password);
                }else{
                    $errorMessage = "Please try again later";
                    $this->setErrors($errorMessage);
                    header("Location: ../login.php");
                }
            }else{
                $errorMessage = "Illegal login attempt";
                $this->setErrors($errorMessage);
                header("Location: ../login.php");
            }
        }

    /**
     * @param $row
     * @param $username
     * @param $password
     */
    function matchPassword($row, $username, $password){
            $storedHash = $row["password"];
                if(!$check = password_verify($password, $storedHash)){
                    $errorMessage = "This user doesn't exist";
                    $this->setErrors($errorMessage);
                }else{
                    $userConn = $GLOBALS["userConn"];
                    $sql = "SELECT userId, username, firstName, lastName, email FROM users WHERE username = ?";

                    if($stmt = $userConn->prepare($sql)) {
                        $stmt->bind_param('s', $username);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                    }
                    $this->loadUser($row);
                }
        }

    /**
     * @param $profiledata
     */
    function loadUser($profiledata){
            $user = $GLOBALS["user"];
            $user->setUserId($profiledata["userId"]);
            $user->setUsername($profiledata["username"]);
            $user->setFName($profiledata["firstName"]);
            $user->setLName($profiledata["lastName"]);
            $user->setEmail($profiledata["email"]);
            if(!session_start()){
                die("Failed to set session");
            }
            $_SESSION["userId"] = $user->getUserId();
            $_SESSION["username"] = $user->getUsername();
            $_SESSION["firstName"] = $user->getFName();
            $_SESSION["lastName"] = $user->getLName();
            $_SESSION["email"] = $user->getEmail();
            header("Location: ../MyProfile.php");
        }
    }