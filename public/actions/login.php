<?php

// Boot application
require_once __DIR__ . '/../../boot/boot.php';

use App\Hotel\User;

// Return to home page if not a post request
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    header('Location: /');

    return;
}

// if there is an already logged in user, return to main page
if (!empty(User::getCurrentUserId())) {
    header('Location: /');

    return;
}

$error = "Your username/password is incorrect";

//Create new user
$user = new User();
// $user->insert($_REQUEST['name'], $_REQUEST['email'], $_REQUEST['password']);

$verification = $user->verify($_REQUEST['email'], $_REQUEST['password']);

// Retrieve user
$userInfo = $user->getByEmail($_REQUEST['email']);



if(empty($verification)) {
    $_SESSION["error"] = $error;
    header('Location: /public/login.php');die;
}

//Generate token
$token = $user->generateToken($userInfo['user_id']);

// Set cookie
setcookie('user_token', $token, time() + (30 * 24 * 60 * 60), '/');

//Return to home page
header('Location: /public/index.php');