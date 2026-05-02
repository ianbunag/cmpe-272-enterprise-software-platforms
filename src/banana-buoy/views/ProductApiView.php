<?php

namespace BananaBuoy\Views;

require_once __DIR__ . '/BaseApiView.php';

class ProductApiView extends BaseApiView
{
    /**
     * Render a list of products with transformed field names and formatted values
     *
     * @param array<int, array{
     *     id: int,
     *     name: string,
     *     origin_country: string,
     *     taste_profile: string,
     *     image_url: string,
     *     alt_text: string,
     *     price: string
     * }> $products Array of product records
     */
    public function render($products): void
    {
        $transformedProducts = [];

        foreach ($products as $product) {
            $transformedProducts[] = [
                'id' => (string) $product['id'],
                'name' => $product['name'] . ' (' . $product['origin_country'] . ')',
                'price' => '$' . number_format((float)$product['price'], 2) . ' per lb',
                'description' => $product['taste_profile'],
                'imageUrl' => $product['image_url'],
                'url' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/banana-buoy/products/' . $product['id']
            ];
        }

        parent::render($transformedProducts);
    }
}
