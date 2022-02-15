<?php

use Hotel\User;
use Hotel\Favorite;

// Boot application
require_once __DIR__ . '/../../boot/boot.php';

// Return to home page if not a post request
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    // header('Location: /');

    return;
}

// If no user is logged in, return to main page
if (empty(User::getCurrentUserId())) {
    // header('Location: /');
    // Small Fix to send user back where he was
    // header('Location: ' . $_SERVER['HTTP_REFERER']);

    return;
}

// Check if room id is given
$roomId = $_REQUEST['room_id'];
if (empty($roomId)) {
    // header('Location: /');

    return;
}

// Set room to favorites
$favorite = new Favorite();



// Add or remove room from favorites****
$is_favorite = $favorite->isFavorite($roomId, User::getCurrentUserId());
// print_r($roomId);
// print_r( User::getCurrentUserId() );

if ( $is_favorite ) {
    $favorite->removeFavorite($roomId, User::getCurrentUserId());   
} else {   
    $favorite->addFavorite($roomId, User::getCurrentUserId()); 
}





// Return to room page
// header(sprintf('Location: /public/room.php?room_id=%s', $roomId));
