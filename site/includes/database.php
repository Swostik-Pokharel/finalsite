<?php
// =========================================================
// database.php: connect to MySQL with PDO.
// Included at the top of every shop page:  require 'includes/database.php';
// After this file runs, $db is a ready-to-use connection.
// =========================================================

$dsn      = 'mysql:host=localhost;dbname=pinkfloyd_archives;charset=utf8mb4';
$username = 'pfa_user';   // created by sql/pinkfloyd_archives.sql (not root)
$password = 'shine0n';    // local-only demo password

try {
    $db = new PDO($dsn, $username, $password);
    // Throw an exception on any SQL error instead of failing silently
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Rows come back as ['productName' => ..., 'listPrice' => ...]
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Show a friendly page instead of a PHP crash (and don't leak connection details)
    $pageTitle = 'Shop unavailable';
    $currentPage = 'shop';
    include __DIR__ . '/header.php';
    echo '<h1>Shop unavailable</h1>';
    echo '<p class="panel">We couldn\'t connect to the shop database. Is MySQL running and was ';
    echo '<code>sql/pinkfloyd_archives.sql</code> imported? See the README.</p>';
    include __DIR__ . '/footer.php';
    exit();
}
