<?php

use Hotel\User;
use Hotel\Review;

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

// Add review
$review = new Review();
$review->insert($roomId, User::getCurrentUserId(), $_REQUEST['rate'], $_REQUEST['comment']);


// Return to room page
header('Location: ' . $_SERVER['HTTP_REFERER']);