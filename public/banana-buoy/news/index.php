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

    $view = new NewsView();
    $view->render(['news' => $news]);
} catch (Exception $e) {
    error_log("Error loading news: " . $e->getMessage());

    $view = new ErrorView(
        'Error Loading News',
        'There was an error loading the news. Please refresh and try again.',
        500
    );
    $view->render();
}
