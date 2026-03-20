<?php

require_once __DIR__ . '/../../../src/banana-buoy/models/AuthModel.php';
require_once __DIR__ . '/../../../src/banana-buoy/models/UserModel.php';
require_once __DIR__ . '/../../../src/lib/ExternalApiClient.php';
require_once __DIR__ . '/../../../src/banana-buoy/views/SecureView.php';
require_once __DIR__ . '/../../../src/banana-buoy/views/AccessDeniedView.php';
require_once __DIR__ . '/../../../src/banana-buoy/views/ErrorView.php';

use BananaBuoy\Models\AuthModel;
use BananaBuoy\Models\UserModel;
use BananaBuoy\Lib\ExternalApiClient;
use BananaBuoy\Views\SecureView;
use BananaBuoy\Views\AccessDeniedView;
use BananaBuoy\Views\ErrorView;

try {
    $authModel = new AuthModel();
    $cookieName = 'banana_buoy_auth';

    // Check if user has valid token
    $token = $_COOKIE[$cookieName] ?? null;
    $tokenData = $token ? $authModel->validateToken($token) : null;

    if (!$tokenData) {
        // No valid token, redirect to login
        header('Location: /banana-buoy/secure/login');
        exit;
    }

    // Check if user is admin
    if ($tokenData['role'] !== 'admin') {
        // User is authenticated but not admin
        $userModel = new UserModel();
        $currentUser = $userModel->getById($tokenData['user_id']);

        $view = new AccessDeniedView();
        $view->render(['currentUser' => $currentUser]);
        exit;
    }

    // User is authenticated admin, show user list
    $userModel = new UserModel();
    $users = $userModel->getAll();
    $currentUser = $userModel->getById($tokenData['user_id']);

    // Fetch external users from configured partner URLs
    $partnerUrlsEnv = getenv('PARTNER_URLS') ?: '';
    $partnerUrls = ExternalApiClient::parseUrlString($partnerUrlsEnv);
    
    $externalUsers = [];
    if (!empty($partnerUrls)) {
        $client = new ExternalApiClient();
        $externalUsers = $client->fetchJsonFromUrls($partnerUrls);
    }

    $view = new SecureView();
    $view->render([
        'users' => $users, 
        'currentUser' => $currentUser,
        'external_users' => $externalUsers
    ]);
} catch (Exception $e) {
    error_log("Error loading secure page: " . $e->getMessage());

    $view = new ErrorView(
        'Error Loading Secure Section',
        'There was an error loading the secure section. Please refresh and try again.',
        500
    );
    $view->render();
}
