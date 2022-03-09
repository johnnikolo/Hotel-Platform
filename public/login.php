<?php

require __DIR__ . '/../boot/boot.php';

use Hotel\User;

// Check for existing logged in user
if (!empty(User::getCurrentUserId())) {
    header('Location: /public/index.php');die;

}

session_start();

?>

<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="robots" content="noindex,nofollow">
      <title>Log In</title>
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
                  <li style="color: #ff5500;">                                        
                      Don't have an account? <i class="fas fa-user-alt"></i>
                       <a href="register.php"> Register now!
                    </a>
                  </li>
                </ul>
            </div>
        </div>
      </header>
      <main class="main-content view_hotel page-home">
        <section class="hero">      
          <form method="post" action="actions/login.php">
            <?php 
            $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            if (strpos($fullUrl, "login=false") == true) {
                echo "<p style='color: red;'>*Wrong email or password!</p>";
            }
            
            ?> 
            <fieldset class="introduction" id="form-introduction">
                 
                  <div class="form-group">
                    <label for="email"><span style="color: red;">*</span>Your E-mail Address:</label>
                    <input id="email" class="form-control" type="email" name="email" placeholder="Your E-mail Address" required>
                  </div>

                  <div class="form-group">
                    <label for="password"><span style="color: red;">*</span>Password:</label>
                    <input id="password" class="form-control" type="password" name="password" placeholder="Type your password" required>
                  </div>

            </fieldset>

            <div class="action text-center">
              <input name="submit" id="submitButton" type="submit" value="Log In">
            </div>
            <?php
                    if(isset($_SESSION["error"])){
                        $error = $_SESSION["error"];
                        echo "<span>$error</span>";
                    }
            ?> 

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
<?php
    unset($_SESSION["error"]);
?>
