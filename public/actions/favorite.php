<?php

use Hotel\User;
use Hotel\Favorite;

// Boot application
require_once __DIR__ . '/../../boot/boot.php';

// Return to home page if not a post request
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    header('Location: /');

    return;
}

// If no user is logged in, return to main page
if (empty(User::getCurrentUserId())) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);

    return;
}

// Check if room id is given
$roomId = $_REQUEST['room_id'];
if (empty($roomId)) {
    header('Location: /');

    return;
}

// Set room to favorites
$favorite = new Favorite();

// Add or remove room from favorites****
$test = $favorite->isFavorite($roomId, User::getCurrentUserId());
// var_dump($test);die;

if ($test == false) {
    $favorite->addFavorite($roomId, User::getCurrentUserId());
} else {   
    $favorite->removeFavorite($roomId, User::getCurrentUserId());
}

// Return to room page
header('Location: ' . $_SERVER['HTTP_REFERER']);
