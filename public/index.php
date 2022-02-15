<?php 

require __DIR__ . '/../boot/boot.php';


use Hotel\User;
use Hotel\Room;
use Hotel\RoomType;

$room = new Room();
$cities = $room->getCities();

// Get all room types
$type = new RoomType();
$allTypes = $type->getAllTypes();


// Check for existing logged in user
if (!empty(User::getCurrentUserId())) {
    // header('Location: /public/index.php');die;

}

?>

<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="robots" content="noindex,nofollow">
      <title>Room Search</title>
      <!-- <script type="text/javascript" src="/js/index_form.js"></script> -->
      <script type="text/javascript" src="/js/index.js"></script>
      <link rel="stylesheet" href="http://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
      <!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
      <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
      <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
      <script>
          $(document).ready(function () {
                var date = new Date();
                var currentMonth = date.getMonth();
                var currentDate = date.getDate();
                var currentYear = date.getFullYear();

                $('#datepicker').datepicker({
                    minDate: new Date(currentYear, currentMonth, currentDate),
                    dateFormat: 'yy-mm-dd'
                });
                $('#datepicker2').datepicker({
                    minDate: new Date(currentYear, currentMonth, currentDate),
                    dateFormat: 'yy-mm-dd'
                });
            });
      </script>     
  </head>
  <body>
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
                  <li>
                      <a href="profile.php">
                      <i class="fas fa-user-alt"></i>
                          Profile
                      </a>                    
                  </li>
                </ul>
            </div>
        </div>
      </header>
            <main class="room-search">
                <form name= "searchForm" method="GET" action="list.php">
                    <section class="room-search-box">  
                        <div class= "centered" style="display:block;">
                                <select name="city" style="padding: 20px; background:#D3D3D3; color:#ffffff; border:none; border-radius: 20px; font-family: 'RobotoL'; font-size: 18px;">
                                    <option value="">City</option>
                                    <?php foreach($cities as $city){ ?>
                                    <option value="<?php echo $city; ?>"><?php echo $city; ?></option>
                                    <?php } ?>
                                </select>
                                <select name="room_type" style="padding: 20px; background:#D3D3D3; color:#ffffff; border:none; border-radius: 20px; font-family: 'RobotoL'; font-size: 18px;">
                                    <option value="">Room Type</option>
                                    <?php foreach($allTypes as $roomType){ ?>
                                    <option value="<?php echo $roomType['type_id']; ?>"><?php echo $roomType['title']; ?></option>
                                    <?php } ?>
                                </select>                     
                        </div> 
                        <div class="dates-form" style="display:grid; width: 30%; position: fixed; top: 30%; left: 50%; transform: translate(-50%, -50%);">
                                    <input type="text" name="check_in_date" id="datepicker" placeholder="Check-In" style="text-align: center; font-family: 'RobotoL'; font-size: 18px; border-radius: 15px;">  
                                    <input type="text" name="check_out_date" id="datepicker2" placeholder="Check-Out" style="text-align: center; font-family: 'RobotoL'; font-size: 18px; border-radius: 15px;"> 
                        </div>
                        <div class="action text-center" id="search-button">
                                    <input id="submitSearchButton" type="submit" value="Search">
                        </div>     
                    </section>
                </form>
            </main>
      <footer>
          <p>CollegeLink 2022</p>
      </footer>
      <link rel="stylesheet" href="/assets/css/fontawesome.min.css">
      <link rel="stylesheet" href="/assets/css/styles.css">
    </body>
</html>