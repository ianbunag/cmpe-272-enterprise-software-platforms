<?php
$id = $_GET['id'] ?? 'id';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow, noarchive">
    <title>Root Dynamic Example - ID: <?= htmlspecialchars($id) ?></title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>
<body>
    <main class="container">
        <article>
            <header>
                <h1>🛍️ Root Dynamic Page</h1>
                <p><mark>Route: /examples/routing/dynamic/<?= htmlspecialchars($id) ?></mark></p>
            </header>

            <section>
                <h2>How It Works</h2>
                <ol>
                    <li>You requested <code>/examples/routing/dynamic/<?= htmlspecialchars($id) ?></code></li>
                    <li>Nginx matched the pattern <code>~^/examples/routing/dynamic/(\d+)$  </code></li>
                    <li>The captured group extracted ID: <strong><?= htmlspecialchars($id) ?></strong></li>
                    <li>Nginx rewrote to <code>/examples/routing/dynamic/id/index.php?id=<?= htmlspecialchars($id) ?></code></li>
                    <li>This PHP file can now use <code>$_GET['id']</code> to personalize the product list</li>
                </ol>
            </section>

            <footer>
                <a href="/examples" role="button">← Examples Navigator</a>
            </footer>
        </article>
    </main>
</body>
</html>

