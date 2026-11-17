<?php
// Shared top of every page. Each page sets $pageTitle and $currentPage
// BEFORE including this file, e.g.:
//   $pageTitle = 'Albums'; $currentPage = 'albums'; include 'includes/header.php';

// Nav items: file => label. Order matches the brief's page numbers (1-6).
$navItems = [
    'index.php'   => 'Home',
    'albums.php'  => 'Albums',
    'tours.php'   => 'Tours',
    'fanwall.php' => 'Fan Wall',
    'shop.php'    => 'Shop',
    'about.php'   => 'About',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pink Floyd Archives: an unofficial fan archive of albums, tours and merch.">
    <title><?php echo htmlspecialchars($pageTitle); ?> | Pink Floyd Archives</title>
    <!-- Bootstrap first (local copy in vendor/, so the site works offline), then our own stylesheet so our rules win -->
    <link rel="stylesheet" href="vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="images/logo.svg" type="image/svg+xml">
</head>
<body>
<!-- Accessibility: keyboard users can jump straight past the header -->
<a class="skip-link" href="#main">Skip to main content</a>

<header class="site-header">
    <!-- Small utility bar: account + read aloud -->
    <div class="top-bar">
        <div class="container d-flex flex-wrap justify-content-end align-items-center gap-2 py-2">
            <!-- Filled in by js/main.js: "Welcome, Name" + Logout, or Sign in / Sign up -->
            <div id="account-area" class="d-flex align-items-center gap-2">
                <a class="btn btn-ghost btn-sm" href="account.php#signin">Sign in</a>
                <a class="btn btn-accent btn-sm" href="account.php#signup">Sign up</a>
            </div>
            <button id="read-aloud" type="button" class="btn btn-ghost btn-sm" aria-pressed="false">
                🔊 Read page aloud
            </button>
        </div>
    </div>

    <!-- Brand: logo, name and tagline, centred like the original site -->
    <div class="brand-block">
        <a href="index.php" class="brand">
            <img src="images/logo.svg" alt="Pink Floyd Archives logo: a prism splitting light" width="64" height="64">
            <span class="brand-name">Pink Floyd Archives</span>
        </a>
        <p class="brand-tagline">Shine on: every album, every tour, one archive.</p>
    </div>

    <nav class="navbar navbar-expand-md site-nav" aria-label="Main navigation">
        <div class="container justify-content-center">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                    aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                Menu
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="mainNav">
                <ul class="navbar-nav">
                    <?php foreach ($navItems as $file => $label): ?>
                        <?php $isActive = ($file === $currentPage . '.php'); ?>
                        <li class="nav-item">
                            <a class="nav-link<?php echo $isActive ? ' active' : ''; ?>" href="<?php echo $file; ?>"
                               <?php echo $isActive ? 'aria-current="page"' : ''; ?>><?php echo $label; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main id="main" class="container py-4" tabindex="-1">
