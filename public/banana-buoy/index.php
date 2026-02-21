<?php

require_once __DIR__ . '/../../src/banana-buoy/views/HomeView.php';
require_once __DIR__ . '/../../src/banana-buoy/views/ErrorView.php';

use BananaBuoy\Views\HomeView;
use BananaBuoy\Views\ErrorView;

try {
    $view = new HomeView();
    $view->render();
} catch (Exception $e) {
    error_log("Error loading home page: " . $e->getMessage());

    $view = new ErrorView(
        'Error Loading Home',
        'There was an error loading the home page. Please refresh and try again.',
        500
    );
    $view->render();
}
