<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex, nofollow, noarchive">

        <link rel="icon" type="image/x-icon" href="/static/favicon.ico">    <title>Named PHP File Example</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    </head>
    <body>
        <main class="container">
            <article>
                <header>
                    <h1>📨 Named PHP File</h1>
                    <p><mark>Route: /examples/routing/php/contact</mark></p>
                </header>
                <section>
                    <h2>Resolution Path</h2>
                    <p>This page was served because:</p>
                    <ol>
                        <li>You requested <code>/examples/routing/php/contact</code></li>
                        <li>Nginx found <code>/examples/routing/php/contact.php</code> ✅</li>
                        <li>Nginx passed it to PHP-FPM for processing</li>
                    </ol>
                    <p><strong>Result:</strong> Dynamic PHP file with custom name executed</p>
                </section>
            <footer>
                <a href="/examples" role="button">← Examples Navigator</a>
            </footer>
            </article>
        </main>
    </body>
</html>
