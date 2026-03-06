<?php
// Scan the lab-activities directory for subdirectories and files
$baseDir = __DIR__;
$items = [];

function scanDirectory($dir, $relativePath = '') {
    $items = [];

    if ($handle = opendir($dir)) {
        while (false !== ($entry = readdir($handle))) {
            $fullPath = $dir . '/' . $entry;
            $itemPath = $relativePath . '/' . $entry;

            // Skip hidden files, current/parent directory references
            if ($entry !== '.' && $entry !== '..' && $entry[0] !== '.') {
                if (is_dir($fullPath)) {
                    // Check if index.php or index.html exists
                    $hasIndexPhp = file_exists($fullPath . '/index.php');
                    $hasIndexHtml = file_exists($fullPath . '/index.html');
                    $hasIndex = $hasIndexPhp || $hasIndexHtml;

                    if ($hasIndex) {
                        $items[] = [
                            'type' => 'directory',
                            'name' => $entry,
                            'path' => '/lab-activities' . $itemPath,
                            'details' => $hasIndexPhp ? 'PHP Index' : 'HTML Index'
                        ];
                    }

                    // Recursively scan subdirectories
                    $subitems = scanDirectory($fullPath, $itemPath);
                    $items = array_merge($items, $subitems);
                } elseif (preg_match('/\.(php|html)$/', $entry) && $entry !== 'index.php' && $entry !== 'index.html') {
                    // It's a PHP or HTML file (but not an index file)
                    $extension = pathinfo($entry, PATHINFO_EXTENSION);
                    $directory = pathinfo($itemPath, PATHINFO_DIRNAME);
                    $nameWithoutExt = pathinfo($entry, PATHINFO_FILENAME);

                    $items[] = [
                        'type' => 'file',
                        'name' => $nameWithoutExt,
                        'path' => '/lab-activities' . $directory . '/' . $nameWithoutExt,
                        'details' => strtoupper($extension) . ' File'
                    ];
                }
            }
        }
        closedir($handle);
    }

    return $items;
}

$items = scanDirectory($baseDir);

// Sort items by path for better organization
usort($items, function($a, $b) {
    return strcmp($a['path'], $b['path']);
});

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex, nofollow, noarchive">
        <title>Lab Activities - CMPE-272</title>
        <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
        <link rel="stylesheet" href="/static/pico.css">
    </head>
    <body>
        <main class="container">
            <article>
                <header>
                    <h1>🧪 Lab Activities</h1>
                    <p><mark>CMPE-272 - Enterprise Software Platforms | Spring 2026</mark></p>
                </header>

                <section>
                    <h2>Available Activities & Files</h2>
                    <?php if (empty($items)): ?>
                        <p><em>No lab activities found.</em></p>
                    <?php else: ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Path</th>
                                    <th>Details</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td>
                                            <?= $item['type'] === 'directory' ? '📁' : '📄' ?>
                                        </td>
                                        <td>
                                            <strong><?= htmlspecialchars($item['name']) ?></strong>
                                        </td>
                                        <td>
                                            <code><?= htmlspecialchars($item['path']) ?></code>
                                        </td>
                                        <td>
                                            <small><?= htmlspecialchars($item['details']) ?></small>
                                        </td>
                                        <td>
                                            <a href="<?= htmlspecialchars($item['path']) ?>" role="button" class="outline">Open →</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </section>

                <section>
                    <h2>About Lab Activities</h2>
                    <p>This directory contains lab activities and exercises completed during the CMPE-272 course.</p>
                    <p>Each lab activity is organized by date (MM-DD format) and contains the work completed during that session.</p>
                </section>

                <footer>
                    <a href="/" role="button">← Back to Home</a>
                </footer>
            </article>
        </main>
    </body>
</html>


