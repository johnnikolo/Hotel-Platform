<?php

use Hotel\User;
use Hotel\Review;

// Boot application
require_once __DIR__ . '/../../boot/boot.php';

// Return to home page if not a post request
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    echo "This is a post script.";
    die;
}

// If no user is logged in, return to main page
if (empty(User::getCurrentUserId())) {
    echo "No current user for this operation.";
    die;
}

// Check if room id is given
$roomId = $_REQUEST['room_id'];
if (empty($roomId)) {
    echo "No room is given for this operation.";
    die;
}

// Add review
$review = new Review();
$review->insert($roomId, User::getCurrentUserId(), $_REQUEST['rate'], $_REQUEST['comment']);


// Return to room page

?>

<div class="room-reviews">
    <h4>
        <span><?php echo sprintf('%d. %s', $counter + 1, $review['user_name']); ?></span>
        <div class="div-reviews">
            <?php                                      
                for ($i = 1; $i <= 5; $i++){
                    if ($_REQUEST['rate'] >= $i) {
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
    <h5>Created at: <?php echo date();?></h5>
    <p><?php echo $_REQUEST['comment'];?></p>
</div>