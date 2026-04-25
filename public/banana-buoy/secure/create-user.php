<?php

require_once __DIR__ . '/../../../src/banana-buoy/models/AuthModel.php';
require_once __DIR__ . '/../../../src/banana-buoy/models/UserModel.php';
require_once __DIR__ . '/../../../src/banana-buoy/views/CreateUserView.php';
require_once __DIR__ . '/../../../src/banana-buoy/views/AccessDeniedView.php';
require_once __DIR__ . '/../../../src/banana-buoy/views/ErrorView.php';

use BananaBuoy\Models\AuthModel;
use BananaBuoy\Models\UserModel;
use BananaBuoy\Views\CreateUserView;
use BananaBuoy\Views\AccessDeniedView;
use BananaBuoy\Views\ErrorView;

try {
    $authModel = new AuthModel();
    $cookieName = 'banana_buoy_auth';

    $token = $_COOKIE[$cookieName] ?? null;
    $tokenData = $token ? $authModel->validateToken($token) : null;

    if (!$tokenData) {
        header('Location: /banana-buoy/secure/login');
        exit;
    }

    if ($tokenData['role'] !== 'admin') {
        $userModel = new UserModel();
        $currentUser = $userModel->getById($tokenData['user_id']);

        $view = new AccessDeniedView();
        $view->render(['currentUser' => $currentUser]);
        exit;
    }

    $userModel = new UserModel();

    $error = null;
    $formData = [
        'username' => '',
        'email' => '',
        'first_name' => '',
        'last_name' => '',
        'home_address' => '',
        'home_phone' => '',
        'cell_phone' => '',
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $firstName = $_POST['first_name'] ?? '';
        $lastName = $_POST['last_name'] ?? '';
        $homeAddress = $_POST['home_address'] ?? '';
        $homePhone = $_POST['home_phone'] ?? '';
        $cellPhone = $_POST['cell_phone'] ?? '';

        if (empty($username) || empty($email) || empty($password) || empty($firstName) || empty($lastName) || empty($homeAddress) || empty($homePhone) || empty($cellPhone)) {
            $error = 'All fields are required';
            $formData = [
                'username' => $username,
                'email' => $email,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'home_address' => $homeAddress,
                'home_phone' => $homePhone,
                'cell_phone' => $cellPhone,
            ];
        } else {
            $result = $userModel->createUser($username, $email, $password, $firstName, $lastName, $homeAddress, $homePhone, $cellPhone);

            if ($result['success']) {
                header('Location: /banana-buoy/secure/?success=1');
                exit;
            } else {
                $error = $result['error'] ?? 'Something went wrong. Please try again later.';
                $formData = [
                    'username' => $username,
                    'email' => $email,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'home_address' => $homeAddress,
                    'home_phone' => $homePhone,
                    'cell_phone' => $cellPhone,
                ];
            }
        }
    }

    $view = new CreateUserView();
    $view->render([
        'error' => $error,
        'formData' => $formData,
    ]);
} catch (Exception $e) {
    error_log("Error loading create user page: " . $e->getMessage());

    $view = new ErrorView(
        'Error Loading Create User Page',
        'There was an error loading the create user page. Please refresh and try again.',
        500
    );
    $view->render();
}

