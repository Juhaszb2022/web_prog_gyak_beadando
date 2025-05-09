<?php
require_once 'blog/includes/auth.php';
?>
<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kezdőlap - Vaszilij EDC</title>
    <link rel="stylesheet" href="./stlye.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <nav>
            <a href="./index.php">Kezdőlap</a>
            <a href="./blog/index.php">Blog</a>
            <a href="./shop.php">Ha Kést szeretnél</a>
            <div class="dropdown">
                <button class="dropbtn"><img src="user.png" alt="" class="login"></button>
                <div class="dropdown-content">
                    <?php if (!isLoggedIn()): ?>
                        <a href="login.php">Bejelentkezés</a>
                        <a href="register.php">Regisztráció</a>
                    <?php else: ?>
                        <form method="POST" action="logout.php">
                            <button type="submit" id="kijelenkezes" name="kijelenkezes">Kijelentkezés</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>
    </header>

    <div class="parallax">
        <div class="overlay-szoveg">
            <h1>Kések, pengék és multi toolok egy helyen</h1>
        </div>
    </div>

    <main>
        <div class="shop">
        <div>
        <h1>Bladeshop</h1>
        <p>Késes webshop gyakori akciókkal és vevőbarát hozzáállással. Ha új kés kell, ne hagyd ki!</p>
        <a href="https://www.bladeshop.hu"><img src="29366421_1622414891184377_7218577531824242688_n.jpg.webp"
                alt=""></a>
        </div>
        <div>
        <h1>Elemlámpa blog</h1>
        <p>Minden, amit az elemlámpákról tudni szeretnél. Cikkek, bemutatók, illetve kuponok gyűjtőhelye. </p><a
            href="https://elemlampablog.hu"><img src="162854478_131232062335812_8008164456523881828_n.jpg.webp"
                alt=""></a></div>
        <div>
        <h1>Késvilág</h1>
        <p>Hazai bolt és webáruház, rendkívül széles termékválasztékkal. Debrecenben személyesen is válogathatsz!</p>
        <a href="https://www.kesvilag.hu"><img src="Kesvilag.jpg.webp" alt=""></a></div>
        <div>
        <h1> Magyar kések</h1>
        <p>Webshop és közösség. Elsősorban a hazai készítők termékeivel foglalkozik, de nyitott egyéb irányokba is.</p>
        <a href="https://www.magyarkesek.hu"><img src="mkszoveglogo.png.webp" alt=""></a>
        </div>
        <div>
        <h1>Késportál</h1>
        <p>Magyarország legnagyobb késes tudásbázisa. Érdemes csatlakoznod a fórumhoz is!</p> <a
            href="https://kesportal.hu"><img src="993918_421456207969831_2037177305_n.jpg.webp" alt=""></a>
        </div>
        <div>
            <h1>ZBOSS</h1>
<p>Kések, edc felszerelések, túra és sok egyéb. Hazai webáruház, ahol a vevők elégedettsége a legfontosabb.</p>
<a href="https://www.zboss.hu"> <img src="ZBOSSweb_fekete_hatterrel-kicsi.jpg.webp" alt=""></a></div>
        </div>
    </main>

    <footer>
        <a href="">Impresszum</a>
        <a href=""> Jogi nyilatkozat</a>
        <a href="">Cookie-Kezelés</a>
        <a href=""> Adatkezelés</a>
    </footer>
    <script src="scripte.js"></script>
</body>

</html>