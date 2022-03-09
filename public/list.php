<?php

require __DIR__. '/../boot/boot.php';

use Hotel\Room;
use Hotel\RoomType;
use Hotel\User;

// use Hotel\User;

// Initialize Room service
$room = new Room();

// Get all cities
$cities = $room->getCities();

// Get all room types
$type = new RoomType();
$allTypes = $type->getAllTypes();

// Get page parameters
$selectedCity = $_REQUEST['city'];
$selectedTypeId = $_REQUEST['room_type'];
$selectedCountofGuests = $_REQUEST['count_of_guests'];
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];

// Search for room

$allAvailableRooms = $room->search(new DateTime($checkInDate), new DateTime($checkOutDate), $selectedCity, $selectedTypeId);
// print_r($allAvailableRooms);die;

// // Check for existing logged in user
// if (!empty(User::getCurrentUserId())) {
//     header('Location: /public/index.php');die;

// }

?>

<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="robots" content="noindex,nofollow">
      <title>Search Results</title>
      <script type="text/javascript" src="/js/list.js"></script>
      <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
      <link rel="stylesheet" href="/resources/demos/style.css">
      <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
      <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
      <script src="assets/pages/search.js"></script>
      <script>
          $(document).ready(function () {
                var date = new Date();
                var currentMonth = date.getMonth();
                var currentDate = date.getDate();
                var currentYear = date.getFullYear();

                $('#datepicker3').datepicker({
                    minDate: new Date(currentYear, currentMonth, currentDate),
                    dateFormat: 'yy-mm-dd'
                });
                $('#datepicker4').datepicker({
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
                  <?php if (!empty(User::getCurrentUserId())) { ?>
                  <li>
                      <a href="profile.php">
                      <i class="fas fa-user-alt"></i>
                          Profile
                      </a>                    
                  </li>
                  <?php } else { ?>
                  <li>
                      <a href="login.php">
                      <i class="fas fa-user-alt"></i>
                          Log-In
                      </a>                    
                  </li>
                  <li style="color: #ff5500;">                   
                    Or
                      <a href="register.php">  Register
                    </a>
                  </li>     
                 <?php }?> 
                </ul>
            </div>
        </div>
      </header>
            <main class="search-results">
                <div class="search-container">
                    <aside class="hotel-search box">
                        <form class="searchForm" method="GET" action="list.php">
                                <select name="count_of_guests" style="padding: 20px; background:#D3D3D3; color:#ffffff; border:none; border-radius: 20px; font-family: 'RobotoL'; font-size: 18px;">
                                    <option value="<?php 
                                                        if (empty($selectedCountofGuests)) {
                                                            echo ("");
                                                        } else {
                                                            echo $selectedCountofGuests; 
                                                        }  
                                                    ?>"><?php 
                                                        if (empty($selectedCountofGuests)) {
                                                            echo ("Count of Guests");
                                                        } else {
                                                            echo $selectedCountofGuests; 
                                                        }  
                                                    ?>                              
                                    </option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>  
                                    <option value="4">4</option>  
                                </select> 
                                <select name="room_type" style="padding: 20px; background:#D3D3D3; color:#ffffff; border:none; border-radius: 20px; font-family: 'RobotoL'; font-size: 18px;">
                                <option value="<?php echo $roomType['type_id'];?>"> 
                                    <?php 
                                        if (empty($selectedTypeId))
                                            echo "Room Type";
                                        if ($selectedTypeId == 1) 
                                            echo 'Single Room'; 
                                        elseif ($selectedTypeId == 2) 
                                            echo "Double Room"; 
                                        elseif ($selectedTypeId == 3) 
                                            echo "Triple Room"; 
                                        elseif ($selectedTypeId == 4) 
                                            echo "Fourfold Room";    
                                    ?>
                                </option>
                                    <?php foreach($allTypes as $roomType){ ?>
                                <option value="<?php echo $roomType['type_id']; ?>"><?php echo $roomType['title']; ?></option>
                                    <?php } ?> 
                                </select>  
                                <?php 
                                    $room = new Room();                           
                                    $cities = $room->getCities();
                                    ?>
                                <select name="city" style="padding: 20px; background:#D3D3D3; color:#ffffff; border:none; border-radius: 20px; font-family: 'RobotoL'; font-size: 18px;">
                                    <option value="<?php echo $selectedCity;?>"> 
                                    <?php 
                                        if (empty($selectedCity))
                                            echo "City";
                                        else
                                            echo $selectedCity;   
                                    ?>
                                    </option>
                                    <?php foreach($cities as $city){ ?>
                                    <option value="<?php echo $city; ?>"><?php echo $city; ?></option>
                                    <?php } ?>
                                </select>
                                <table class="price-range">
                                    <tr>
                                        <td><input type="text" id="amount_min" name="min_price" placeholder="Price Min"></td>
                                        <td><input type="text" id="amount_max" name="max_price" placeholder="Price Max"></td>
                                    </tr>
                                </table>                       
                                <div class="dates-form">
                                    <input type="text" value= "<?php echo $checkInDate;?>" name="check_in_date" id="datepicker3" placeholder="Check-In" style="text-align: center; font-family: 'RobotoL'; font-size: 18px; border-radius: 15px;">  
                                    <input type="text" value= "<?php echo $checkOutDate;?>" name="check_out_date" id="datepicker4" placeholder="Check-Out" style="text-align: center; font-family: 'RobotoL'; font-size: 18px; border-radius: 15px;"> 
                                </div>
                            <div class="action">
                                <input id="submitButton" type="submit" value="FIND HOTEL">
                            </div>
                        </form>
                    </aside>
                    <section class="hotel-list box" id= "search-results-container">
                        <header class="page-title">
                            <h2>Search Results</h2>
                        </header>
                        <article class="hotel">
                            <?php 
                                foreach($allAvailableRooms as $availableRoom) {
                            ?>
                            <aside class="media">
                                <img src="assets/images/rooms/<?php echo $availableRoom[photo_url]; ?>" width="30%" height="auto" id="hotel-img"/>
                            </aside>
                            <main class="info">                               
                                <h2><?php echo $availableRoom[name]; ?></h2>
                                <h1><?php echo $availableRoom[city]; ?>, <?php echo $availableRoom[area]; ?></h1>
                                <p><?php echo $availableRoom[description_short]; ?></p>
                                <div class="text-right">
                                    <button type="button" name="button" class="btn-primary">
                                        <a href="room.php?room_id=<?php echo $availableRoom[room_id];?>&check_in_date=<?php echo $checkInDate;?>&check_out_date=<?php echo $checkOutDate;?>">Go to room page</a>
                                    </button>
                                </div>
                                <table class="property-info" id="property-info">
                                    <tr>
                                        <td>Per Night: <?php echo $availableRoom[price]; ?></td>
                                        <td>Count of Guests: <?php echo $availableRoom[count_of_guests]; ?></td>
                                        <td>Type of Room: 
                                        <?php
                                        if ($availableRoom[type_id] == 1) 
                                            echo 'Single Room'; 
                                        elseif ($availableRoom[type_id] == 2) 
                                            echo "Double Room"; 
                                        elseif ($availableRoom[type_id] == 3) 
                                            echo "Triple Room"; 
                                        else 
                                            echo "Fourfold Room"; 
                                        ?>                                                                                                                            
                                        </td>
                                    </tr>                           
                                </table>
                            </main>
                            <div class="clear"></div>
                            <hr>
                            <?php
                                 } 
                            ?>
                        </article>
                        <?php 
                            if (count($allAvailableRooms) == 0) {   ?>                         
                                <h2 style= "color:#FF0000"><strong>There are no available rooms matching your search criteria!</strong></h2>                       
                        <?php } ?>        
                    </section>
                </div>
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