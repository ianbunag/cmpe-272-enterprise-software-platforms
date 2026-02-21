<?php

require_once __DIR__ . '/../../../src/banana-buoy/models/ProductModel.php';
require_once __DIR__ . '/../../../src/banana-buoy/views/ProductDetailView.php';
require_once __DIR__ . '/../../../src/banana-buoy/views/ErrorView.php';

use BananaBuoy\Models\ProductModel;
use BananaBuoy\Views\ProductDetailView;
use BananaBuoy\Views\ErrorView;

$productId = $_GET['productId'] ?? null;

// Validate ID
if (!$productId || !is_numeric($productId)) {
    $view = new ProductDetailView();
    $view->render(['product' => null]);
    exit;
}

try {
    $productModel = new ProductModel();
    $product = $productModel->getById((int)$productId);

    $view = new ProductDetailView();

    if ($product) {
        $view->render(['product' => $product]);
    } else {
        $view->render(['product' => null]);
    }
} catch (Exception $e) {
    error_log("Error loading product details: " . $e->getMessage());

    $view = new ErrorView(
        'Error Loading Product',
        'There was an error loading the product details. Please try again.',
        500
    );
    $view->render();
}

