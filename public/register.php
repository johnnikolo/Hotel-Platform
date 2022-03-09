<?php

require __DIR__ . '/../boot/boot.php';

use Hotel\User;

// Check for existing logged in user
if (!empty(User::getCurrentUserId())) {
    header('Location: /public/index.php');die;

}

?>

<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="robots" content="noindex,nofollow">
      <title>Register</title>
      <script src="assets/pages/register.js"></script>
  </head>
  <body class="fixing-css">
      <header>
        <div class="container">
            <p class="main-logo">Hotels</p>
            <div class="primary-menu text-right">
                <ul>
                  <li>
                    <a href="index.php">
                      <i class="fas fa-home"></i>
                      Home
                    </a>
                  </li>
                  </li>
                  <li style="color: #ff5500;">                                  
                      Already have an account? <i class="fas fa-user-alt"></i>
                       <a href="login.php"> Log-In here!
                    </a>
                  </li>
                </ul>
            </div>
        </div>
      </header>
      <main class="main-content view_hotel page-home room-search">
        <section class="hero">      
          <form method="post" action="actions/register.php">
            <?php 
            $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            if (strpos($fullUrl, "signup=empty") == true) {
                echo "<p style='color: red;'>*This email already exists, try logging in</p>";
            }
            
            ?>          
            <fieldset class="introduction" id="form-introduction">

                  <div class="form-group">
                    <label for="name"><span style="color: red;">*</span>Your Name:</label>
                    <input id="name" class="form-control" type="text" name="name" placeholder="Your Name" required>
                  </div>

                  <div class="form-group">
                    <label for="email"><span style="color: red;">*</span>Your E-mail Address:</label>
                    <input id="email" class="form-control" type="email" name="email" placeholder="Your E-mail Address" required>
                  </div>

                  <div class="email-error hide" style="color: red;">
                    *Must be a valid email address!
                  </div>

                  <div class="form-group">
                    <label for="email_repeat"><span style="color: red;">*</span>Verify your E-mail:</label>
                    <input id="email_repeat" class="form-control" type="email" name="email_repeat" placeholder="Verify your E-mail" required>
                  </div>

                  <div class="verify-error hide" style="color: red;">
                    *Must match your email address!
                  </div>
                
                  <div class="form-group">
                    <label for="password"><span style="color: red;">*</span>Password:</label>
                    <input id="password" class="form-control" type="password" name="password" placeholder="Type your password" required>
                  </div>

            </fieldset>

            <div class="action text-center">
              <input name="registersubmit" id="submitButton" type="submit" value="Register">
            </div>

          </form>
        </section>
      </main>
      <footer>
        <p>CollegeLink
        &copy
        <script>
            document.write(new Date().getFullYear());
        </script> 
        </p>
      </footer>
      <link rel="stylesheet" href="assets/css/fontawesome.min.css">
      <link rel="stylesheet" href="assets/css/styles.css">
    </body>
</html>
