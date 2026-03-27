<?php
namespace BananaBuoy\Lib;
use Exception;

class ExternalApiClient
{
    /**
     * Parse a comma-separated URL string into an array of URLs
     *
     * @param string $urlString Comma-separated URLs
     * @return array<int, string> Array of URLs
     */
    public static function parseUrlString(string $urlString): array
    {
        if (empty($urlString)) {
            return [];
        }
        $urls = array_map('trim', explode(',', $urlString));
        return array_filter($urls, function ($url) {
            return !empty($url) && filter_var($url, FILTER_VALIDATE_URL);
        });
    }
    /**
     * Fetch JSON data from multiple URLs using curl
     *
     * @param array<int, string> $urls Array of URLs to fetch from
     * @return array<int, array{
     *     name: string,
     *     partner_url: string
     * }> Array of user records from all URLs with partner URL info
     */
    public function fetchJsonFromUrls(array $urls): array
    {
        $allUsers = [];
        foreach ($urls as $url) {
            try {
                $users = $this->fetchJsonFromUrl($url);
                if (is_array($users)) {
                    // Add partner URL to each user record
                    foreach ($users as $user) {
                        $userWithPartner = is_array($user) ? $user : ['name' => $user];
                        $userWithPartner['partner_url'] = $url;
                        $allUsers[] = $userWithPartner;
                    }
                }
            } catch (Exception $e) {
                error_log("Error fetching from $url: " . $e->getMessage());
            }
        }
        return $allUsers;
    }
    /**
     * Fetch JSON data from a single URL using curl with redirect following
     *
     * @param string $url The URL to fetch from
     * @return array<int, array> Array of user records
     * @throws Exception If curl fails or JSON is invalid
     */
    private function fetchJsonFromUrl(string $url): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'BananaBuoy/1.0');
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        if ($error) {
            throw new Exception("Curl error: $error");
        }
        if ($httpCode !== 200) {
            throw new Exception("HTTP error: $httpCode");
        }
        if (!$response) {
            throw new Exception("Empty response from $url");
        }
        $data = json_decode($response, true);
        if (!is_array($data)) {
            throw new Exception("Invalid JSON response from $url");
        }
        return $data;
    }
}
