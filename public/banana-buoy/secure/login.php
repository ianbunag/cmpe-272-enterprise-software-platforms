<?php

require_once __DIR__ . '/../../../src/banana-buoy/models/AuthModel.php';
require_once __DIR__ . '/../../../src/banana-buoy/views/LoginView.php';
require_once __DIR__ . '/../../../src/banana-buoy/views/ErrorView.php';

use BananaBuoy\Models\AuthModel;
use BananaBuoy\Views\LoginView;
use BananaBuoy\Views\ErrorView;

try {
    $authModel = new AuthModel();
    $cookieName = 'banana_buoy_auth';
    $showError = false;

    // If user is already authenticated, redirect to secure section
    if (isset($_COOKIE[$cookieName])) {
        $tokenData = $authModel->validateToken($_COOKIE[$cookieName]);
        if ($tokenData) {
            header('Location: /banana-buoy/secure/');
            exit;
        }
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $authModel->authenticate($username, $password);

        if ($user) {
            // Generate token
            $token = $authModel->generateToken($user['id'], $user['role']);

            // Set secure cookie with HttpOnly, SameSite, and Secure flags
            $secure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
            setcookie(
                $cookieName,
                $token,
                [
                    'expires' => time() + 3600,
                    'path' => '/banana-buoy/secure/',
                    'httponly' => true,
                    'samesite' => 'Strict',
                    'secure' => $secure
                ]
            );

            // Redirect to secure section
            header('Location: /banana-buoy/secure/');
            exit;
        } else {
            // Authentication failed
            $showError = true;
        }
    }

    // Render login form
    $view = new LoginView($showError);
    $view->render();
} catch (Exception $e) {
    error_log("Error loading login page: " . $e->getMessage());

    $view = new ErrorView(
        'Error Loading Login',
        'There was an error loading the login page. Please refresh and try again.',
        500
    );
    $view->render();
}

