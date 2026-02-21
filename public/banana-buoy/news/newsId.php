<?php

require_once __DIR__ . '/../../../src/banana-buoy/models/NewsModel.php';
require_once __DIR__ . '/../../../src/banana-buoy/views/NewsDetailView.php';
require_once __DIR__ . '/../../../src/banana-buoy/views/ErrorView.php';

use BananaBuoy\Models\NewsModel;
use BananaBuoy\Views\NewsDetailView;
use BananaBuoy\Views\ErrorView;

$newsId = $_GET['newsId'] ?? null;

// Validate ID
if (!$newsId || !is_numeric($newsId)) {
    $view = new NewsDetailView();
    $view->render(['article' => null]);
    exit;
}

try {
    $newsModel = new NewsModel();
    $article = $newsModel->getById((int)$newsId);

    $view = new NewsDetailView();

    if ($article) {
        $view->render(['article' => $article]);
    } else {
        $view->render(['article' => null]);
    }
} catch (Exception $e) {
    error_log("Error loading news article: " . $e->getMessage());

    $view = new ErrorView(
        'Error Loading Article',
        'There was an error loading the article details. Please try again.',
        500
    );
    $view->render();
}
