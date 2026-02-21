<?php
// Scan the examples directory for subdirectories and files
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

                    $items[] = [
                        'type' => 'directory',
                        'name' => $entry,
                        'path' => '/examples' . $itemPath,
                        'hasIndex' => $hasIndex,
                        'indexType' => $hasIndexPhp ? 'PHP' : ($hasIndexHtml ? 'HTML' : null)
                    ];

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
                        'fullName' => $entry,
                        'path' => '/examples' . $directory . '/' . $nameWithoutExt,
                        'fileType' => strtoupper($extension)
                    ];
                }
            }
        }
        closedir($handle);
    }

    return $items;
}

$items = scanDirectory($baseDir);

// Filter out directories with no index file (optional, depending on how you want to handle them)
$items = array_filter($items, function($item) {
    return !($item['type'] === 'directory' && !$item['hasIndex']);
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow, noarchive">
    <title>Examples - CMPE-272</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>
<body>
    <main class="container">
        <article>
            <header>
                <h1>📚 Examples Navigator</h1>
                <p><mark>CMPE-272 - Enterprise Software Platforms | Spring 2026</mark></p>
            </header>

            <section>
                <h2>Available Examples</h2>
                <?php if (empty($items)): ?>
                    <p><em>No examples found.</em></p>
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
                                        <?php if ($item['type'] === 'directory'): ?>
                                            📁 Directory
                                        <?php else: ?>
                                            📄 File
                                        <?php endif; ?>
                                    </td>
                                    <td><strong><?= htmlspecialchars($item['name']) ?></strong></td>
                                    <td><code><?= htmlspecialchars($item['path']) ?></code></td>
                                    <td>
                                        <?php if ($item['type'] === 'directory'): ?>
                                            <?php if ($item['hasIndex']): ?>
                                                <span style="color: #2ecc71;">✅ <?= $item['indexType'] ?> Index</span>
                                            <?php else: ?>
                                                <span style="color: #e74c3c;">❌ No Index</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span style="color: #3498db;"><?= $item['fileType'] ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($item['type'] === 'directory' && !$item['hasIndex']): ?>
                                            <button disabled>No Index</button>
                                        <?php else: ?>
                                            <a href="<?= htmlspecialchars($item['path']) ?>" role="button">View →</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </section>

            <section>
                <h2>About Examples</h2>
                <p>This directory contains code examples and demonstrations for various repository functionalities such as routing.</p>
            </section>

            <footer>
                <a href="/" role="button">← Back to Home</a>
            </footer>
        </article>
    </main>
</body>
</html>

