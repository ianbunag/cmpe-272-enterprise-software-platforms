<?php

namespace BananaBuoy\Models;

use PDO;
use PDOException;

require_once __DIR__ . '/DatabaseModel.php';

class ProductModel
{
    private PDO $db;
    private const RECENT_PRODUCTS_COOKIE = 'recent_products';
    private const PRODUCT_VISITS_COOKIE = 'product_visits';
    private const MAX_RECENT_PRODUCTS = 5;
    private const COOKIE_LIFETIME = 2592000; // 30 days in seconds
    private const MAX_COOKIE_SIZE = 4000; // Typical max cookie size is ~4096 bytes

    public function __construct()
    {
        $database = new DatabaseModel();
        $this->db = $database->getConnection();
    }

    /**
     * @return array<int, array{
     *     id: int,
     *     name: string,
     *     origin_country: string,
     *     taste_profile: string,
     *     image_url: string,
     *     alt_text: string,
     *     price: string
     * }> Array of all product records, empty array on error
     */
    public function getAll(): array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT id, name, origin_country, taste_profile, image_url, alt_text, price 
                FROM products 
                ORDER BY name ASC
            ");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error fetching products: " . $e->getMessage());
            return [];
        }
    }

    /**
     * @return array{
     *     id: int,
     *     name: string,
     *     origin_country: string,
     *     taste_profile: string,
     *     image_url: string,
     *     alt_text: string,
     *     price: string
     * }|null Product record if found, null if not found or error occurs
     */
    public function getById(int $id): ?array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT id, name, origin_country, taste_profile, image_url, alt_text, price 
                FROM products 
                WHERE id = :id
            ");
            $stmt->execute(['id' => $id]);
            $result = $stmt->fetch();

            return $result ?: null;
        } catch (PDOException $e) {
            error_log("Error fetching product: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Track a product view by updating cookies.
     * Uses FIFO for recent products: removes ID if exists, appends to end, caps at 5.
     * Increments visit count in separate cookie.
     * Validates input ID and cookie sizes before updating.
     *
     * @param int $id Product ID to track
     * @return bool True if tracking was successful, false if ID was invalid
     */
    public function trackProductView(int $id): bool
    {
        // Update recent products (FIFO)
        $recentIds = $this->getRecentProductIds();

        // Remove if already exists
        $recentIds = array_filter($recentIds, fn($pid) => $pid !== $id);
        $recentIds = array_values($recentIds); // Re-index

        // Append to end (most recent at end)
        $recentIds[] = $id;

        // Trim to last 5 (FIFO eviction)
        if (count($recentIds) > self::MAX_RECENT_PRODUCTS) {
            $recentIds = array_slice($recentIds, -self::MAX_RECENT_PRODUCTS);
        }

        // Prepare cookie value
        $recentCookieValue = implode(',', $recentIds);

        // Validate size before setting
        if (strlen($recentCookieValue) > self::MAX_COOKIE_SIZE) {
            error_log("Recent products cookie would exceed max size");
            $this->resetRecentProductsCookie();
            return false;
        }

        // Save recent products cookie
        setcookie(
            self::RECENT_PRODUCTS_COOKIE,
            $recentCookieValue,
            time() + self::COOKIE_LIFETIME,
            '/'
        );

        // Update visit counts
        $visits = $this->getVisitCounts();
        $visits[$id] = ($visits[$id] ?? 0) + 1;

        // Prepare cookie value
        $visitsCookieValue = json_encode($visits);

        // Validate size before setting
        if (strlen($visitsCookieValue) > self::MAX_COOKIE_SIZE) {
            error_log("Product visits cookie would exceed max size");
            $this->resetVisitsCookie();
            return false;
        }

        // Save visit counts cookie
        setcookie(
            self::PRODUCT_VISITS_COOKIE,
            $visitsCookieValue,
            time() + self::COOKIE_LIFETIME,
            '/'
        );

        return true;
    }

    /**
     * Get recently viewed product IDs from cookie in storage order (oldest to newest).
     * Note: getRecentProducts() reverses this for display (newest to oldest).
     * Validates cookie and resets if invalid.
     *
     * @return array<int> Array of product IDs in storage order (oldest first, newest last)
     */
    private function getRecentProductIds(): array
    {
        $cookie = $_COOKIE[self::RECENT_PRODUCTS_COOKIE] ?? '';
        if (empty($cookie)) {
            return [];
        }

        // Validate cookie size
        if (strlen($cookie) > self::MAX_COOKIE_SIZE) {
            error_log("Recent products cookie exceeds max size: " . strlen($cookie) . " bytes");
            $this->resetRecentProductsCookie();
            return [];
        }

        $ids = explode(',', $cookie);
        return array_filter(array_map('intval', $ids));
    }

    /**
     * Get visit count map from cookie.
     * Validates cookie and resets if invalid.
     *
     * @return array<int, int> Map of product ID to visit count
     */
    private function getVisitCounts(): array
    {
        $cookie = $_COOKIE[self::PRODUCT_VISITS_COOKIE] ?? '';
        if (empty($cookie)) {
            return [];
        }

        // Validate cookie size
        if (strlen($cookie) > self::MAX_COOKIE_SIZE) {
            error_log("Product visits cookie exceeds max size: " . strlen($cookie) . " bytes");
            $this->resetVisitsCookie();
            return [];
        }

        $data = json_decode($cookie, true);
        return is_array($data) ? array_map('intval', $data) : [];
    }

    /**
     * Reset the product visits cookie (clear it).
     */
    private function resetVisitsCookie(): void
    {
        setcookie(
            self::PRODUCT_VISITS_COOKIE,
            '',
            time() - 3600,
            '/'
        );
        unset($_COOKIE[self::PRODUCT_VISITS_COOKIE]);
    }

    /**
     * Get recently viewed products in order (newest to oldest).
     *
     * @return array<int, array{
     *     id: int,
     *     name: string,
     *     origin_country: string,
     *     taste_profile: string,
     *     image_url: string,
     *     alt_text: string,
     *     price: string
     * }> Array of product records in recent view order (newest first)
     */
    public function getRecentProducts(): array
    {
        $ids = $this->getRecentProductIds();
        if (empty($ids)) {
            return [];
        }

        // Reverse to show newest first
        $ids = array_reverse($ids);

        return $this->getByIdsOrdered($ids);
    }

    /**
     * Get most visited products (top 5, sorted by visit count desc, then ID asc).
     *
     * @return array<int, array{
     *     id: int,
     *     name: string,
     *     origin_country: string,
     *     taste_profile: string,
     *     image_url: string,
     *     alt_text: string,
     *     price: string
     * }> Array of top 5 most visited product records
     */
    public function getMostVisitedProducts(): array
    {
        $visits = $this->getVisitCounts();
        if (empty($visits)) {
            return [];
        }

        // Sort by count desc, then ID asc
        arsort($visits, SORT_NUMERIC);
        $visits = array_slice($visits, 0, 5, true);

        $ids = array_keys($visits);

        // Fetch products and sort by visit count desc, then ID asc
        $products = $this->getByIdsOrdered($ids);

        // Re-sort by visit count desc, then ID asc
        usort($products, function ($a, $b) use ($visits) {
            $countCmp = $visits[$b['id']] <=> $visits[$a['id']];
            return $countCmp !== 0 ? $countCmp : $a['id'] <=> $b['id'];
        });

        return $products;
    }

    /**
     * Fetch products by IDs, preserving the order of provided IDs.
     *
     * @param array<int> $ids Array of product IDs to fetch
     * @return array<int, array{
     *     id: int,
     *     name: string,
     *     origin_country: string,
     *     taste_profile: string,
     *     image_url: string,
     *     alt_text: string,
     *     price: string
     * }> Array of product records in requested ID order
     */
    private function getByIdsOrdered(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        try {
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $stmt = $this->db->prepare("
                SELECT id, name, origin_country, taste_profile, image_url, alt_text, price 
                FROM products 
                WHERE id IN ($placeholders)
            ");
            $stmt->execute($ids);
            $products = $stmt->fetchAll();

            // Create map for quick lookup
            $productMap = [];
            foreach ($products as $product) {
                $productMap[$product['id']] = $product;
            }

            // Return in requested ID order
            $result = [];
            foreach ($ids as $id) {
                if (isset($productMap[$id])) {
                    $result[] = $productMap[$id];
                }
            }

            return $result;
        } catch (PDOException $e) {
            error_log("Error fetching products by IDs: " . $e->getMessage());
            return [];
        }
    }
}
