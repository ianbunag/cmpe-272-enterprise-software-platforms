<?php

$version = file_exists(__DIR__ . '/../VERSION') ? trim(file_get_contents(__DIR__ . '/../VERSION')) : 'v0.0.0';
$repoUrl = getenv('REPO_URL') ?: '#';

try {
    $pdo = new PDO(
        'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME'),
        getenv('DB_USER'),
        getenv('DB_PASSWORD'),
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    $dbStatus = '✅ Connected';
} catch (Exception $e) {
    $dbStatus = '❌ Disconnected';
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex, nofollow, noarchive">
        <title>John Ian Buñag | CMPE-272</title>
        <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    </head>
    <body>
        <main class="container">
            <article>
                <header>
                    <h1>John Ian Buñag</h1>
                    <p>Software Engineering, MS | Cybersecurity Specialization<br>San José State University</p>
                    <mark>CMPE-272 - Enterprise Software Platforms | Spring 2026</mark>
                </header>

            <table>
                <tr><td>📅 Date</td><td><?= date('F j, Y') ?></td></tr>
                <tr><td>🐘 PHP</td><td><?= phpversion() ?></td></tr>
                <tr><td>🗄️ Database</td><td><?= $dbStatus ?></td></tr>
                <tr><td>🏷️ Version</td><td><?= $version ?></td></tr>
            </table>

            <section>
                <h2>Navigation</h2>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <a href="/lab-activities" role="button">🧪 Lab Activities</a>
                    <a href="/examples" role="button" class="secondary">📚 Examples</a>
                </div>
            </section>

            <footer>
                    <a href="<?= htmlspecialchars($repoUrl) ?>" role="button" target="_blank">📂 View Source Code</a>
                </footer>
            </article>
        </main>
    </body>
</html>
