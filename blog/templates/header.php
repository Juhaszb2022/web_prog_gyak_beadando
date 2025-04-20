<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Vaszilij EDC</title>
    <link rel="stylesheet" href="/web_prog_gyak_beadando/stlye.css">
</head>
<body>
<header>
    <nav>
            <a href="/web_prog_gyak_beadando/index.php">Kezdőlap</a>
            <a href="/web_prog_gyak_beadando/blog/index.php">Blog</a>
            <a href="/web_prog_gyak_beadando/shop.php">Ha Kést szeretnél</a>
            <div class="dropdown">
                <button class="dropbtn"><img src="/web_prog_gyak_beadando/user.png" alt="" class="login"></button>
                <div class="dropdown-content">
                    <?php if (!isLoggedIn()): ?>
                        <a href="/web_prog_gyak_beadando/login.php">Bejelentkezés</a>
                        <a href="/web_prog_gyak_beadando/register.php">Regisztráció</a>
                    <?php else: ?>
                        <form method="POST" action="/web_prog_gyak_beadando/logout.php">
                            <button type="submit" id="kijelenkezes" name="kijelenkezes">Kijelentkezés</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
</header>
<div class="parallax">
    <div class="overlay-szoveg">
        <h1>Kések, pengék és multi toolok egy helyen</h1>
    </div>
</div>
<div class="content">