<?php
require_once __DIR__ . '/../includes/db.php';     
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/nav.php';
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaszilij EDC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <?php
        $page = $_GET['page'] ?? 'home';
    ?>
            <link rel="stylesheet" href="stilus/main.css">
    <?php if ($page === 'blog'|| $page ==='report'||$page ==='post'): ?>
        <link rel="stylesheet" href="stilus/blog.css">
    <?php elseif ($page === 'login' || $page === 'register'): ?>
        <link rel="stylesheet" href="stilus/rl.css">
    <?php elseif ($page === 'shop'): ?>
        <link rel="stylesheet" href="stilus/shop.css">
    <?php endif; ?>
</head>
<body>
<header>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="index.php">Vaszilij EDC</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <?php foreach ($nav as $key => $label): ?>
                <?php if (($key === 'login' || $key === 'register') && !isLoggedIn()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=<?= $key ?>"><?= $label ?></a>
                    </li>
                <?php elseif ($key === 'logout' && isLoggedIn()): ?>
                    <li class="nav-item">
                        <form method="POST" action="logout.php" class="d-inline">
                            <button type="submit" class="btn btn-link nav-link" style="padding: 0; color: inherit;">
                                <?= $label ?>
                            </button>
                        </form>
                    </li>
                <?php elseif (!in_array($key, ['login', 'register', 'logout'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=<?= $key ?>"><?= $label ?></a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>

        <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="img/user.png" alt="Felhasználó" class="rounded-circle" style="width: 30px; height: 30px;">
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <?php if (!isLoggedIn()): ?>
                        <li><a class="dropdown-item" href="index.php?page=login">Bejelentkezés</a></li>
                        <li><a class="dropdown-item" href="index.php?page=register">Regisztráció</a></li>
                    <?php else: ?>
                        <li>
                            <form method="POST" action="logout.php" class="d-inline">
                                <button type="submit" name="kijelenkezes" class="dropdown-item">Kijelentkezés</button>
                            </form>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>

            <li class="nav-item d-flex align-items-center ms-3 text-white">
                <?php if (isLoggedIn()): ?>
                    <span>Bejelentkezve mint: <strong><?= htmlspecialchars(getLoggedInUsername($db)) ?></strong></span>
                <?php else: ?>
                    <span>Nem vagy bejelentkezve</span>
                <?php endif; ?>
            </li>

            <?php if (isAdmin()): ?>
                <li class="nav-item ms-3">
                    <a href="index.php?page=admin_reports" class="btn btn-outline-warning">Admin hibák</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
</header>

<div class="parallax">
    <div class="overlay-szoveg">
        <h1>Kések, pengék és multi toolok egy helyen</h1>
    </div>
</div>


