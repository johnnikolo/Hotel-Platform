<?php

require __DIR__. '/../boot/boot.php';

use Hotel\Favorite;
use Hotel\User;
use Hotel\Review;
use Hotel\Booking;

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


// Check for existing logged in user
$userId = User::getCurrentUserId();
if (empty($userId)) {
    header('Location: index.php');

    return;
}

// Get all favorites
$favorite = new Favorite();
$userFavorites = $favorite->getListByUser($userId);

// Get all reviews
$review = new Review();
$userReviews = $review->getListByUser($userId);

// Get all user bookings
$booking = new Booking();
$userBookings = $booking->getListByUser($userId);

?>

<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="robots" content="noindex,nofollow">
      <title>Profile Page</title>
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
            <main class="search-results">
                <div class="search-container">
                    <aside class="hotel-search box">
                       <div class="favorites-list">
                            <h2 style="color:red;">FAVORITES</h2>
                            <?php if (count($userFavorites) > 0) {
                            ?>
                            <ol>
                                <?php foreach ($userFavorites as $favorite) { ?>
                                <h3>
                                    <li>
                                        <h3>
                                            <a href="/public/room.php?room_id=<?php echo $favorite['room_id'];?>"><?php echo $favorite['name'];?></a>
                                        </h3>
                                    </li>
                                </h3>
                                <?php } ?>
                            </ol>
                            <?php 
                                } else {
                            ?>    
                            <h4 class="alert-profile" style="color:red;">You don't have a favourite hotel yet!</h4>
                            <?php } 
                            ?>
                       </div>
                       <hr>
                       <div class="reviews-list">
                            <h2 style="color:red;">REVIEWS</h2>
                            <?php if (count($userReviews) > 0) {
                            ?>
                            <ol>
                            <?php foreach ($userReviews as $review) { ?>                           
                                <h3>
                                    <li>
                                        <h3>
                                            <a href="/public/room.php?room_id=<?php echo $review['room_id'];?>"><?php echo $review['name'];?></a>
                                            <br>
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
                                        </h3>
                                    </li>
                                </h3>
                            <?php 
                            }
                            ?>
                            </ol>
                            <?php 
                            } else {
                            ?>  
                            <h4 class="alert-profile" style="color:red;">You haven't made a review yet!</h4>
                            <?php 
                            }
                            ?> 
                       </div>
                    </aside>
                    <section class="hotel-list box">
                        <header class="page-title">
                            <h2>My Bookings</h2>
                        </header>
                        <?php if (count($userBookings) > 0) {
                            ?>
                        <?php foreach ($userBookings as $booking) { ?>    
                        <article class="hotel">
                            <aside class="media">
                                <img src="assets/images/rooms/<?php echo $booking['photo_url']; ?>" width="30%" height="auto" id="hotel-img"/>
                            </aside>
                            <main class="info">                               
                                <h2><?php echo $booking['name']; ?></h2>
                                <h1><?php echo $booking['city']; ?>, <?php echo $booking['area']; ?></h1>
                                <p><?php echo $booking['description_short']; ?></p>
                                <div class="text-right">
                                    <button type="button" name="button" class="btn-primary">
                                        <a href="room.php?room_id=<?php echo $booking['room_id']; ?>">Go to room page</a>
                                    </button>
                                </div>
                                <table class="property-info" id="property-info">
                                    <tr>
                                        <td>Total Cost: <?php echo $booking['total_price']; ?>€</td>
                                        <td>Check-in-Date: <?php echo $booking['check_in_date']; ?></td>
                                        <td>Check-out-Date: <?php echo $booking['check_out_date']; ?></td>
                                        <td>Type of Room: <?php echo $booking['room_type']; ?></td>
                                    </tr>                           
                                </table>
                            </main>
                            <div class="clear"></div>
                            <hr>
                        </article>
                        <?php 
                            }
                        ?>
                        <?php 
                            } else {
                        ?>                      
                        <h2 style= "color:#FF0000"><strong>You haven't booked any rooms yet!</strong></h2>
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