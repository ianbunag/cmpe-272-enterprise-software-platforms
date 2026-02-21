<?php

require_once __DIR__ . '/../../../src/banana-buoy/models/ProductModel.php';
require_once __DIR__ . '/../../../src/banana-buoy/views/ProductsView.php';
require_once __DIR__ . '/../../../src/banana-buoy/views/ErrorView.php';

use BananaBuoy\Models\ProductModel;
use BananaBuoy\Views\ProductsView;
use BananaBuoy\Views\ErrorView;

try {
    $productModel = new ProductModel();
    $products = $productModel->getAll();

    $view = new ProductsView();
    $view->render(['products' => $products]);
} catch (Exception $e) {
    error_log("Error loading products: " . $e->getMessage());

    $view = new ErrorView(
        'Error Loading Products',
        'There was an error loading the products. Please refresh and try again.',
        500
    );
    $view->render();
}
