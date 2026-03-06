<?php
/**
 * Price Calculator Script
 *
 * This script processes an array of product prices and calculates:
 * - Total cost of the order
 * - Average price per item
 * - Highest price in the array
 */

// Array of product prices
$prices = [12.5, 8.99, 5.25, 20];

// Check if the array is empty
if (empty($prices)) {
    echo "No prices available.";
} else {
    // Calculate total price
    $total = array_sum($prices);

    // Calculate average price
    $average = $total / count($prices);

    // Find the highest price
    $highest = max($prices);

    // Format and print the results
    printf("Total: $%.2f<br>\n", $total);
    printf("Average: $%.2f<br>\n", $average);
    printf("Highest: $%.2f<br>\n", $highest);
}
?>

