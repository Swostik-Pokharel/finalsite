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
    <!-- Bootstrap first, then our own stylesheet so our rules win -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="images/logo.svg" type="image/svg+xml">
</head>
<body>
<!-- Accessibility: keyboard users can jump straight past the header -->
<a class="skip-link" href="#main">Skip to main content</a>

<header class="site-header">
    <div class="container d-flex flex-wrap align-items-center justify-content-between gap-3 py-3">
        <a href="index.php" class="brand d-flex align-items-center gap-3 text-decoration-none">
            <img src="images/logo.svg" alt="Pink Floyd Archives logo: a prism splitting light" width="56" height="56">
            <span>
                <span class="brand-name d-block">Pink Floyd Archives</span>
                <span class="brand-tagline d-block">Shine on: every album, every tour, one archive.</span>
            </span>
        </a>

        <div class="d-flex flex-wrap align-items-center gap-2">
            <!-- Filled in by js/main.js: "Welcome, Name" + Logout, or Sign in / Sign up -->
            <div id="account-area" class="d-flex align-items-center gap-2">
                <a class="btn btn-outline-light btn-sm" href="account.php#signin">Sign in</a>
                <a class="btn btn-accent btn-sm" href="account.php#signup">Sign up</a>
            </div>
            <button id="read-aloud" type="button" class="btn btn-outline-light btn-sm" aria-pressed="false">
                🔊 Read page aloud
            </button>
        </div>
    </div>

    <nav class="navbar navbar-expand-md navbar-dark site-nav" aria-label="Main navigation">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                    aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
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
