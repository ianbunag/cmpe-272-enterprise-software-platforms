<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex, nofollow, noarchive">
        <title>PHP Directory Index Example</title>
        <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    </head>
    <body>
        <main class="container">
            <article>
                <header>
                    <h1>🐘 PHP Directory Index</h1>
                    <p><mark>Route: /examples/routing/php/</mark></p>
                </header>
                <section>
                    <h2>Resolution Path</h2>
                    <p>This page was served because:</p>
                    <ol>
                        <li>You requested <code>/examples/routing/php</code> or <code>/examples/routing/php/</code></li>
                        <li>Nginx checked for <code>/examples/routing/php</code> (exact file) ❌</li>
                        <li>Nginx checked for <code>/examples/routing/php.html</code> ❌</li>
                        <li>Nginx checked for <code>/examples/routing/php.php</code> ❌</li>
                        <li>Nginx found <code>/examples/routing/php/index.php</code> ✅</li>
                        <li>Nginx passed it to PHP-FPM for processing</li>
                    </ol>
                    <p><strong>Result:</strong> Dynamic PHP directory index executed</p>
                </section>
            <footer>
                <a href="/examples" role="button">← Examples Navigator</a>
            </footer>
            </article>
        </main>
    </body>
</html>
