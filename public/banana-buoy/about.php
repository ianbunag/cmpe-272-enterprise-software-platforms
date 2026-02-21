<?php

require_once __DIR__ . '/../../src/banana-buoy/views/AboutView.php';
require_once __DIR__ . '/../../src/banana-buoy/views/ErrorView.php';

use BananaBuoy\Views\AboutView;
use BananaBuoy\Views\ErrorView;

try {
    $view = new AboutView();
    $view->render();
} catch (Exception $e) {
    error_log("Error loading about page: " . $e->getMessage());

    $view = new ErrorView(
        'Error Loading About',
        'There was an error loading the about page. Please refresh and try again.',
        500
    );
    $view->render();
}
