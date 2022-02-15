<?php

require __DIR__. '/../boot/boot.php';

use Hotel\Room;
use Hotel\Favorite;
use Hotel\User;
use Hotel\Review;

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

?>
<!DOCTYPE>
<html>
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="robots" content="noindex,nofollow">
      <title>Room Page</title>
      <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
      <script src="./index.js"></script>
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
      <main>
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
                                            if ($roomAvgReview > $i) {
                                                ?> <span class="fas fa-star"></span>
                                                <?php                
                                            } else {
                                                ?> <span class="far fa-star"></span>
                                                <?php    
                                            }
                                        }
                                    ?>
                                </td>
                                    <div class="title-reviews" id="favorite">
                                        <form name="favoriteForm" method="post" id="favoriteForm" class="favoriteForm" action="actions/favorite.php">
                                            <input type="hidden" name="room_id" value="<?php echo $roomId; ?>">
                                            <input type="hidden" name="is_favorite" value="<?php echo $isFavorite ? '1' : '0'; ?>">
                                            <div class="search_stars_div">
                                                <ul class="fav_star">
                                                        <td>
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
                        <section class="availability-buttons" style="float: right;">
                            <form method="GET" action="book.php">
                                <input id="BookButton" type="submit" value="Book Now">
                            </form>
                            <button type="button" id="already-booked">Already Booked</button>
                        </section>
                        <h3><strong>Room Description</strong></h3>
                        <p><?php echo $roomInfo['description_long']; ?></p>
                    </section>
                    <!-- <div id="map"></div> -->
                    <hr>
                    <div class="caption">
                        <h3>Reviews</h3>
                        <br>
                        <div class="room-reviews">
                            <h4>
                                <span>1. John Doe</span>
                                <div class="div-reviews">
                                    <span class="fas fa-star"></span>
                                    <span class="fas fa-star"></span>
                                    <span class="fas fa-star"></span>
                                    <span class="far fa-star"></span>
                                    <span class="far fa-star"></span>
                                </div>
                            </h4>
                            <h5>Created at: 2022-01-01 13:32</h5>
                            <p>Review Comment</p>
                        </div>
                    </div>
                    <hr>
                    <div class="caption caption-room">
                        <h3>Add Review</h3>
                        <br>
                        <form name="reviewForm" method="post" action="actions/review.php">
                            <input type="hidden" name="room_id" value="1">
                            <h4>
                                <fieldset class="rating">
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
                                <input type="hidden" name="review" value="review">
                            </div>
                            <div class="form-group_landing">
                                <button style="padding: 13px; border-radius: 10px;"type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
            </div>
      </main>
      <footer>
          <p>CollegeLink 2022</p>
      </footer>
      <link rel="stylesheet" href="assets/css/fontawesome.min.css">
      <link rel="stylesheet" href="assets/css/styles.css">
    </body>
</html>