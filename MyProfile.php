<?php
    session_start();
    if(!isset($_SESSION["username"])){
        header("Location: login.php");
    }else{
        $userId = $_SESSION["userId"];
        $username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ufanisi : My Account</title>
    <script src="js/jquery.min.js"></script>
    <link href="css/w3.min.css" rel="stylesheet">
    <?php
    require_once "classes/Booking.php";
    $book = new Booking;
    ?>
</head>
<body class="w3-container" style="background-color: #2a3133">
    <header class="w3-panel">
        <nav class="w3-black">
            <ul class="w3-navbar w3-container">
                <li><a href="index.php#home">Home</a></li>
                <li><a href="index.php#aboutus">About Us</a></li>
                <li><a href="index.php#booking">Book Parking Spot</a></li>
                <li><a href="index.php#contactus">Contact Us</a></li>
                <li><a href="manage.php">Manage Profile</a></li>
                <li class="w3-right"><a href="logout.php" class="w3-teal">Log Out</a></li>
            </ul>
        </nav>
    </header>
    <div class="w3-container">
        <div class="w3-row">
            <ul class="w3-navbar">
                <li>Names: <?php echo $_SESSION["firstName"] . " " . $_SESSION["lastName"]; ?></li>
                <li class="w3-right">Username: <?php echo strtoupper($_SESSION["username"]); ?></li>
            </ul>
        </div>
        <form action="<?php echo htmlentities("dynamic_data/BookSpot.php")?>" method="post" name="bookForm" class="w3-border w3-padding">
            <label class="w3-label">Currently Available Spot: </label>
            <input type="text" name="position" id="position" class="w3-input" required readonly>
            <label class="w3-label">Date:</label>
            <input type="date" name="bookDate" class="w3-input w3-select" required>
            <label class="w3-label">Time In:</label>
            <input type="time" name="timeIn" class="w3-input" required>
            <label class="w3-label">Time Out:</label>
            <input type="time" name="timeOut" class="w3-input" required><br>
            <p class="w3-center">
                <input type="submit" value="Book Now!!" class="w3-btn w3-medium w3-round-jumbo">
                <input type="reset" value="Cancel" class="w3-btn w3-medium w3-round-jumbo">
            </p>
        </form>
    <div class="w3-responsive">
        <h3>My Bookings</h3>
        <blockquote>All unpaid bookings are reserved for 3 minutes</blockquote>
        <table class="w3-table-all">
            <tr>
                <th>Booking Id</th>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Spot</th>
                <th>Receipt Number</th>
                <th>Reservation Time</th>
                <th>Status</th>
            </tr>
            <?php
            $book->loadBookings($userId);
            ?>
        </table>
    </div>
    <div>
        <?php $book->getSpotStatus($userId); ?>
    </div>
    <script>
        $(function(){
            window.setInterval(function(){
                $.get('dynamic_data/SaveSensorData.php', function(data){
                    if(data !== ""){
                        $("#position").val(data);
                        $(":submit").prop("disabled", false);
                        $(":reset").prop("disabled", false);
                    }
                    else{
                        $("#position").val("No spot available");
                        $(":submit").prop("disabled", true);
                        $(":reset").prop("disabled", true);
                    }
                });
            }, 1000);
        });
    </script>
    </div>
    <footer class="w3-container">
        <p class="w3-center"> Developed by: <a href="https://www.milleradulu.co.ke" target="_blank">Adulu Miller</a></p>
    </footer>
</body>
</html>
<?php } ?>