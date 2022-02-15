<?php

require __DIR__ . '/../boot/boot.php';

use Hotel\User;

// Get cities
$user = new User();
$userRecord = $user->getByEmail('john@doe.com');
print_r($userRecord);



// $cities = $room->getCities();
// print_r($cities);

// // Check for existing logged in user
// if (!empty(User::getCurrentUserId())) {
//     header('Location: /public/index.php');die;

// }

// Search rooms
// $rooms = $room->search('Athens', 2, new DateTime('2020-08-01'), new DateTime('2020-08-31'));
// print_r($rooms);
