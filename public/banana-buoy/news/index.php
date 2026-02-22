<?php

require_once __DIR__ . '/../../../src/banana-buoy/models/NewsModel.php';
require_once __DIR__ . '/../../../src/banana-buoy/views/NewsView.php';
require_once __DIR__ . '/../../../src/banana-buoy/views/ErrorView.php';

use BananaBuoy\Models\NewsModel;
use BananaBuoy\Views\NewsView;
use BananaBuoy\Views\ErrorView;

try {
    $newsModel = new NewsModel();
    $news = $newsModel->getAll();

    $subscribed = false;

    // Handle newsletter subscription form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        if ($email) {
            // Subscription successful
            $subscribed = true;
            error_log("Newsletter subscription: $email");
        }
    }

    $view = new NewsView();
    $view->render([
        'news' => $news,
        'subscribed' => $subscribed
    ]);
} catch (Exception $e) {
    error_log("Error loading news: " . $e->getMessage());

    $view = new ErrorView(
        'Error Loading News',
        'There was an error loading the news. Please refresh and try again.',
        500
    );
    $view->render();
}
