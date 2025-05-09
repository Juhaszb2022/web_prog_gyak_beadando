<?php
require_once 'blog/includes/auth.php';
?>
<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kezdőlap - Vaszilij EDC</title>
    <link rel="stylesheet" href="/web_prog_gyak_beadando/stlye.css">
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
                <button class="dropbtn"><img src="/web_prog_gyak_beadando/user.png" alt="" class="login"></button>
                <div class="dropdown-content">
                    <?php if (!isLoggedIn()): ?>
                        <a href="./login.php">Bejelentkezés</a>
                        <a href="./register.php">Regisztráció</a>
                    <?php else: ?>
                        <form method="POST" action="logout.php">
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
        <main>
            <img src="IMG_20180614_163340_1.jpg.webp" alt="Vaszilij">
            <h1>Naplónak indult.</h1>
            <h2>Bemutató bloggá vált.</h2>
            <p>Aztán átalakult valami mássá. Ablakká, amelyben kitekintek a világra, a világ meg betekinthet a
                gondolataimba: késekről, every day carry felszerelésekről, és az ezek mögött meghúzódó filozófiáról.</p>
    
            <p>Aztán ennél is több lett. Egy közösség, amelyben együtt, hasonló értékek mentén dolgozunk azért, hogy egy
                minőségi, kissé talán régimódi találkahely legyen ez az online térben.</p>
    
            <p>Balogh József vagyok, és azon dolgozom, hogy ez a közösség egyre nagyobbá váljon, és együtt adhassuk tovább
                ezek az értékeket. Tarts velünk te is!</p>
            <h2>De mi az az EDC?</h2>
            <p>Egy angol betűszó, amely kibontva az every day carry kifejezést takarja. Ez szó szerinti fordításban azokat a holmikat jelenti, amelyeket nap mint nap magunknál hordunk. A közkeletű tévhittel ellentétben nem szükséges az, hogy mindig minden nap nálunk legyen: inkább egyfajta készletről, gyűjteményről van szó, amelynek elemeit az adott szituációnak megfelelően váltogathatjuk. Más holmikat pakolunk el, ha egy irodába megyünk dolgozni, mást, ha egy építkezésen melózunk, és akkor is, amikor hétvégén rokonlátogatóba megyünk.</p>
    
            <p>Ezen a blogon főképp késekről olvashatsz, mert hozzám ezek az eszközök állnak legközelebb, de szó esik néha másról is. Multiszerszámokról, táskákról, egyéb kiegészítőkről. És nem csak bemutatókat készítek: ahogy már írtam, sokféle aspektusa érdekel ennek a világnak.</p>
                
            <p>Az every day carry tehát sok minden lehet. Életmód, filozófia, hobbi, vagy akár egy gyűjtőszenvedély alapja. Mindegy, hogy téged melyik része érdekel, remélem, találsz itt értékes olvasnivalót.</p>
        </main>
        </div>

    <footer>
        <a href="">Impresszum</a>
        <a href="">Jogi nyilatkozat</a>
        <a href="">Cookie-Kezelés</a>
        <a href="">Adatkezelés</a>
    </footer>
    <script src="scripte.js"></script>
</body>

</html>
