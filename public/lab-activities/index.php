<?php
// Scan the lab-activities directory for subdirectories
$baseDir = __DIR__;
$directories = [];

if ($handle = opendir($baseDir)) {
    while (false !== ($entry = readdir($handle))) {
        $fullPath = $baseDir . '/' . $entry;
        // Skip hidden files, current/parent directory references, and non-directories
        if ($entry !== '.' && $entry !== '..' && $entry[0] !== '.' && is_dir($fullPath)) {
            // Check if index.php or index.html exists
            $hasIndex = file_exists($fullPath . '/index.php') || file_exists($fullPath . '/index.html');
            $directories[] = [
                'name' => $entry,
                'path' => '/lab-activities/' . $entry,
                'hasIndex' => $hasIndex,
            ];
        }
    }
    closedir($handle);
}

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
    </head>
    <body>
        <main class="container">
            <article>
                <header>
                    <h1>🧪 Lab Activities</h1>
                    <p><mark>CMPE-272 - Enterprise Software Platforms | Spring 2026</mark></p>
                </header>

                <section>
                    <h2>Available Lab Activities</h2>
                    <?php if (empty($directories)): ?>
                        <p><em>No lab activities found.</em></p>
                    <?php else: ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Path</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($directories as $dir): ?>
                                    <tr>
                                        <td><code><?= htmlspecialchars($dir['path']) ?></code></td>
                                        <td>
                                            <?php if ($dir['hasIndex']): ?>
                                                <span style="color: #2ecc71;">✅ Available</span>
                                            <?php else: ?>
                                                <span style="color: #e74c3c;">❌ No Index</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($dir['hasIndex']): ?>
                                                <a href="<?= htmlspecialchars($dir['path']) ?>" role="button">View →</a>
                                            <?php else: ?>
                                                <button disabled>No Index</button>
                                            <?php endif; ?>
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
