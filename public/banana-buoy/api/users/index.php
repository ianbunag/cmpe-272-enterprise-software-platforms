<?php

require_once __DIR__ . '/../../../../src/banana-buoy/models/UserModel.php';
require_once __DIR__ . '/../../../../src/banana-buoy/views/UserApiView.php';

use BananaBuoy\Models\UserModel;
use BananaBuoy\Views\UserApiView;

// Create the model and fetch all users
$userModel = new UserModel();
$users = $userModel->getAll();

// Create the view and render the response
$view = new UserApiView();
$view->render($users);

