<?php

require_once __DIR__ . '/../../../src/banana-buoy/models/ProductModel.php';
require_once __DIR__ . '/../../../src/banana-buoy/views/ProductApiView.php';

use BananaBuoy\Models\ProductModel;
use BananaBuoy\Views\ProductApiView;

$productModel = new ProductModel();
$products = $productModel->getAll();

$view = new ProductApiView();
$view->render($products);
