<?php

require __DIR__. '/../boot/boot.php';

use Hotel\Room;
use Hotel\Favorite;
use Hotel\User;
use Hotel\Review;
use Hotel\Booking;

// Initialize Room service
$room = new Room();
$favorite = new Favorite();

// Check for room id
$roomId = $_REQUEST['room_id'];
if (empty($roomId)) {
    header('Location: index.php');
    
    return;
}

//Load room info
$roomInfo = $room->get($roomId);
if (empty($roomInfo)) {
    header('Location: index.php');
    
    return;
}

// Get current user id
$userId = User::getCurrentUserId();
// var_dump($userId);

// Check if room is favorite for current user
$isFavorite = $favorite->isFavorite($roomId, $userId);
// var_dump($isFavorite);die;

// Load all rooms reviews
$review = new Review();
$allReviews = $review->getReviewsByRoom($roomId);
// print_r($allReviews);die;

//Check for booking room
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];
$alreadyBooked = empty($checkInDate) || empty($checkOutDate);
// $alreadyBooked = false;
if (!$alreadyBooked) {
    //Look for bookings
    $booking = new Booking();
    $alreadyBooked  = $booking->isBooked($roomId, $checkInDate, $checkOutDate);
    // var_dump($alreadyBooked);die;
}



?>
<!DOCTYPE>
<html>
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="robots" content="noindex,nofollow">
      <title>Room Page</title>
      <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
      <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
      <!-- <script src="assets/pages/room.js"></script> -->
      <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
  </head>
  <body class="overflow-fix">
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
      <main class="room-page-name">
            <div class="room-container room-centered" role="main">
                    <section class="room-title">
                        <table class="room-title-info" id="room-title-info">
                            <tr>
                                <td><?php echo sprintf('%s - %s, %s', $roomInfo['name'], $roomInfo['city'], $roomInfo['area']) ?> |</td>
                                <td>
                                    <span>Reviews:<span>
                                    <?php
                                        $roomAvgReview = $roomInfo['avg_reviews'];
                                        for ($i = 1; $i <= 5; $i++){
                                            if ($roomAvgReview >= $i) {
                                                ?> <span class="fas fa-star"></span>
                                                <?php                
                                            } else {
                                                ?> <span class="far fa-star"></span>
                                                <?php    
                                            }
                                        }
                                    ?>
                                </td>
                                    <?php if (!empty($userId)) {    ?>
                                    <div class="title-reviews" id="favorite">
                                        <form name="favoriteForm" method="post" id="favoriteForm" class="favoriteForm" action="actions/favorite.php">
                                            <input type="hidden" name="room_id" value="<?php echo $roomId; ?>">
                                            <input type="hidden" name="is_favorite" value="<?php echo $isFavorite ? '1' : '0'; ?>">
                                            <div class="search_stars_div">
                                                <ul class="fav_star">
                                                        <td id="ajaxtd">
                                                            <?php if ($isFavorite == 1) { ?>
                                                            <i class="fas fa-heart"></i>
                                                            <input name="remove" id="RemButton" type="submit" value="Remove from Favorites">
                                                            <?php } ?>
                                                            <?php if ($isFavorite == 0) { ?>
                                                            <i class="far fa-heart"></i>
                                                            <input name="add" id="FavButton" type="submit" value="Add to Favorites"> 
                                                            <?php } ?>   
                                                        </td>
                                                </ul>
                                            </div>
                                        </form>
                                    </div>
                                    <?php } ?>                    
                                <td>Per Night: <?php echo $roomInfo['price']; ?>€</td>
                            </tr>                           
                        </table>                 
                    </section>
                    <section class="photos">
                        <img alt="Room Name" src="assets/images/rooms/<?php echo $roomInfo['photo_url']?>" class="room-image">
                    </section>
                    <section class="room-tags">
                        <table class="room-tags-info" id="room-tags-info">
                            <tr>
                                <td>COUNT OF GUESTS <i class="fas fa-user-friends"></i><?php echo $roomInfo['count_of_guests']; ?></td>
                                <td>TYPE OF ROOM <i class="fas fa-bed"></i><?php echo $roomInfo['type_id']; ?></td>                                   
                                <?php if ($roomInfo['parking'] == 1) { ?>
                                <td>PARKING <i class="fas fa-parking"></i></td>
                                <?php } ?>
                                <?php if ($roomInfo['wifi'] == 1) { ?>
                                <td>WIFI <i class="fas fa-wifi"></i></td>
                                <?php } ?>
                                <?php if ($roomInfo['pet_friendly'] == 1) { ?>
                                <td>PET FRIENDLY <i class="fas fa-paw"></i></td>
                                <?php } ?>
                            </tr>                           
                        </table>                 
                    </section>
                    <section class="room-description">                        
                        <h3><strong>Room Description</strong></h3>
                        <p><?php echo $roomInfo['description_long']; ?></p>
                        <section class="availability-buttons">
                            <?php if ($alreadyBooked) {  
                            ?>
                            <button type="button" id="already-booked">Already Booked</button>
                            <?php
                                  } else {
                            ?>       
                                <form method="post" action="actions/book.php">
                                    <?php 
                                        $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                        if (strpos($fullUrl, "book=nouser") == true) {
                                            echo "<p style='color: red;'>*You must be logged in to book a room!</p>";
                                        }
                                    
                                    ?>                                
                                    <input type="hidden" name="room_id" value="<?php echo $roomId;?>">
                                    <input type="hidden" name="check_in_date" value="<?php echo $checkInDate;?>">
                                    <input type="hidden" name="check_out_date" value="<?php echo $checkOutDate;?>">
                                    <input name="" type="submit" value="Book Now" class="btn-primary">
                                </form>
                                <?php 
                                     }
                                ?>                               
                        </section>
                    </section>
                    <!-- <div id="map"></div> -->
                    <hr>
                    <iframe width='100%' height='450px' src="https://api.mapbox.com/styles/v1/johnnikolo/ckzv6f1mn007z14jyci12cpvg.html?title=false&access_token=pk.eyJ1Ijoiam9obm5pa29sbyIsImEiOiJja3p1a3c4eGcxY2oxMndvOXp4d2ZtOXZiIn0.onsLFG01xXF5DmwxWqvW6w&zoomwheel=false#9/<?php echo $roomInfo['location_lat'];?>/<?php echo $roomInfo['location_long'];?>" title="Streets" style="border:none;"></iframe>
                    <hr>
                    <div class="caption">
                        <h3>Reviews</h3>
                        <br>
                        <?php 
                            foreach ($allReviews as $counter => $review) {
                        ?>                   
                        <div class="room-reviews">
                            <h4>
                                <span><?php echo sprintf('%d. %s', $counter + 1, $review['user_name']); ?></span>
                                <div class="div-reviews">
                                    <?php                                      
                                        for ($i = 1; $i <= 5; $i++){
                                            if ($review['rate'] >= $i) {
                                                ?> <span class="fas fa-star"></span>
                                                <?php                
                                            } else {
                                                ?> <span class="far fa-star"></span>
                                                <?php    
                                            }
                                        }
                                    ?>
                                </div>
                            </h4>
                            <h5>Created at: <?php echo $review['created_time']?></h5>
                            <p><?php echo htmlentities($review['comment']);?></p>
                        </div>
                        <?php
                        }
                        ?>                    

                    </div>
                    <hr>
                    <?php if (!empty($userId)) { ?>
                    <div class="caption caption-room">
                        <h3>Add Review</h3>
                        <br>
                        <form class= "reviewForm" name="reviewForm" method="post" action="actions/review.php">
                            <input type="hidden" name="room_id" value="<?php echo $roomId?>">
                            <h4>
                                <fieldset class="rating" required>
                                    <input type="radio" id="star5" name="rate" value="5"/><label for="star5" title="text">Awesome - 5 Stars</label>
                                    <input type="radio" id="star4" name="rate" value="4"/><label for="star4" title="text">Pretty good - 4 Stars</label>
                                    <input type="radio" id="star3" name="rate" value="3"/><label for="star3" title="text">Meh - 3 Stars</label>
                                    <input type="radio" id="star2" name="rate" value="2"/><label for="star2" title="text">Kinda bad - 2 Stars</label>
                                    <input type="radio" id="star1" name="rate" value="1"/><label for="star1" title="text">Awfull - 1 Star</label>
                                </fieldset>
                            </h4>
                            <br>
                            <div class="floating-label-form-group controls">
                                <textarea name="comment" id="reviewField" class="review-textarea" placeholder="Review" required></textarea>
                            </div>
                            <div class="form-group_landing">
                                <button style="padding: 13px; border-radius: 10px;" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                    <?php } ?>
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