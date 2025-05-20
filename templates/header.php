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
    <nav> 
        <?php foreach ($nav as $key => $label): ?>
            <?php if (($key === 'login' || $key === 'register') && !isLoggedIn()): ?>
                <a href="index.php?page=<?= $key ?>"><?= $label ?></a>
            <?php elseif ($key === 'logout' && isLoggedIn()): ?>
                <form method="POST" action="logout.php" style="display:inline;">
                    <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;">
                        <?= $label ?>
                    </button>
                </form>
            <?php elseif (!in_array($key, ['login', 'register', 'logout'])): ?>
                <a href="index.php?page=<?= $key ?>"><?= $label ?></a>
            <?php endif; ?>
        <?php endforeach; ?>
        <div class="dropdown">
        <button class="dropbtn"><img src="img/user.png" alt="Felhasználó" class="login"></button>
        <div class="dropdown-content">
            <?php if (!isLoggedIn()): ?>
                <a href="index.php?page=login">Bejelentkezés</a>
                <a href="index.php?page=register">Regisztráció</a>
            <?php else: ?>
                <form method="POST" action="logout.php">
                    <button type="submit" name="kijelenkezes">Kijelentkezés</button>
                </form>
            <?php endif; ?>
        </div>
    </div>

        <span style="margin-left: auto; color: #fff;">
            <?php if (isLoggedIn()): ?>
                Bejelentkezve mint: <strong><?= htmlspecialchars(getLoggedInUsername($db)) ?></strong>
            <?php else: ?>
                Nem vagy bejelentkezve
            <?php endif; ?>
        </span>
        <?php if (isAdmin()): ?>
    <a href="index.php?page=admin_reports">
        <button>Admin hibák</button>
    </a>
<?php endif; ?>
    </nav>


</header>

<div class="parallax">
    <div class="overlay-szoveg">
        <h1>Kések, pengék és multi toolok egy helyen</h1>
    </div>
</div>


