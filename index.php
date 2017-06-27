<!DOCTYPE html>
<html>
  <head>
    <title>Ufanisi</title>
    <link href="css/w3.min.css" rel="stylesheet">
  </head>
  <body class="w3-containe">
    <div class="w3-row">
      <header class="w3-panel">
          <nav class="w3-black">
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
      <div id="home" class="w3-panel w3-margin w3-center">
          <img src="images/landing.jpg" alt="Landing Image" class="w3-responsive">
      </div>
      <div id="aboutus" class="w3-panel w3-margin">
          <p> We aim to provide access to faster parking services. Your time is to precious to waste it on driving around
          looking for a parking spot. Through our automated parking monitoring system, we give you access to
          the nearest and most convenient parking spots available in town. </p>
      </div>
      <div id="booking" class="w3-panel w3-margin">
          <a href="MyProfile.php" class="w3-btn-block w3-red w3-round-large w3-jumbo">Book Now !!!! </a>
      </div>
      <div id="contactus" class="w3-panel w3-margin">
          <h2 class="w3-center">Talk to Us!</h2>
          <fieldset>
              <form method="post" action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>">
                  <label class="w3-label">Name</label>
                  <input type="text" name="contactName" class="w3-input"><br>
                  <label class="w3-label">Email</label>
                  <input type="email" name="contactEmail" class="w3-input"><br>
                  <label class="w3-label">Subject</label>
                  <input type="text" name="contactSubject" class="w3-input"><br>
                  <label class="w3-label">Message</label>
                  <textarea name="contactMessage" col="6" rows="5" class="w3-input"></textarea><br>
                  <input type="submit" value="Send" class="w3-btn w3-ripple w3-large">
                  <input type="reset" value="Change of Mind" class="w3-btn w3-ripple  w3-large">
              </form>
          </fieldset>
      </div>
    </div>
  <footer class="w3-container">
      <p class="w3-center"> Developed by: <a href="https://www.milleradulu.co.ke" target="_blank">Adulu Miller</a></p>
  </footer>
  </body>
</html>
