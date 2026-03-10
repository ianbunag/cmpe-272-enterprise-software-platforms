<?php

// Clear the authentication cookie
$cookieName = 'banana_buoy_auth';
setcookie(
    $cookieName,
    '',
    [
        'expires' => time() - 3600,
        'path' => '/banana-buoy/secure/',
        'httponly' => true,
        'samesite' => 'Strict'
    ]
);

// Redirect to login page
header('Location: /banana-buoy/secure/login');
exit;

