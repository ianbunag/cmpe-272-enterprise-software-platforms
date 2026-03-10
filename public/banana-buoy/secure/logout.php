<?php

// Clear the authentication cookie
$cookieName = 'banana_buoy_auth';
$secure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
setcookie(
    $cookieName,
    '',
    [
        'expires' => time() - 3600,
        'path' => '/banana-buoy/secure/',
        'httponly' => true,
        'samesite' => 'Strict',
        'secure' => $secure
    ]
);

// Redirect to login page
header('Location: /banana-buoy/secure/login');
exit;

