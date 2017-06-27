<!DOCTYPE html>
<html>
  <head>
    <title>Ufanisi</title>
    <link href="css/w3.min.css" rel="stylesheet">
  </head>
  <body>
    <div>
      <header>
          <nav class="w3-black w3-padding">
              <ul class="w3-navbar w3-container">
                  <li><a href="#home">Home</a></li>
                  <li><a href="#aboutus">About Us</a></li>
                  <li><a href="#booking">Book Parking Spot</a></li>
                  <li><a href="#contactus">Contact Us</a></li>
                  <li class="w3-right">
                      <?php
                      session_start();
                      if(isset($_SESSION["username"])){ ?>
                      <a href="MyProfile.php" class="w3-teal">Back to my Account</a>
                      <?php }else{?>
                      <a href="login.php" class="w3-teal">Login to my Account</a>
                      <?php } ?>
                  </li>
              </ul>
          </nav>
      </header>
      <div id="home" class="w3-center w3-container" style="background-color: #000000">
          <img src="images/landing.jpg" alt="Landing Image" class="w3-image">
      </div>
      <div id="aboutus" class="w3-panel w3-padding" style="background-color: #474044;">
          <p> We aim to provide access to faster parking services. Your time is to precious to waste it on driving around
          looking for a parking spot. Through our automated parking monitoring system, we give you access to
          the nearest and most convenient parking spots available in town. </p>
      </div>
      <div id="booking" class="w3-panel w3-padding" style="background-color: #4F5165;">
          <a href="MyProfile.php" class="w3-btn-block w3-red w3-round-large w3-jumbo">Book Now !!!! </a>
      </div>
      <div id="contactus" class="w3-panel w3-padding" style="background-color: #547AA5;">
          <h2 class="w3-center">Talk to Us!</h2>
              <form method="post" action="<?php echo htmlentities("PHPMailer/Message.php"); ?>">
                  <input type="text" name="contactName" class="w3-input" placeholder="Name..." required><br>
                  <input type="email" name="contactEmail" class="w3-input" placeholder="Email..." required><br>
                  <input type="text" name="contactSubject" class="w3-input" placeholder="Subject..." required><br>
                  <textarea name="contactMessage" col="6" rows="5" class="w3-input" placeholder="Message..." required></textarea><br>
                  <input type="submit" value="Send" class="w3-btn w3-ripple w3-large">
                  <input type="reset" value="Change of Mind" class="w3-btn w3-ripple  w3-large">
              </form>
      </div>
    </div>
  <footer class="w3-container w3-padding" style="background-color: #50D8D7;">
      <p class="w3-center"> Developed by: <a href="https://www.milleradulu.co.ke" target="_blank">Adulu Miller</a></p>
  </footer>
  </body>
</html>
