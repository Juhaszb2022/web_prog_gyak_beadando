<?php
session_start();
require_once 'blog/includes/db.php';
require_once 'blog/includes/auth.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['is_admin'] = $user['is_admin'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Hibás email vagy jelszó.";
    }
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés - Vaszilij EDC</title>
    <link rel="stylesheet" href="./stlye.css">
</head>
<body>
<header>
    <nav>
        <a href="/web_prog_gyak_beadando/index.php">Kezdőlap</a>
        <a href="/web_prog_gyak_beadando/blog/index.php">Blog</a>
        <a href="/web_prog_gyak_beadando/shop.php">Ha Kést szeretnél</a>
    </nav>
</header>
<div class="parallax">
    <div class="overlay-szoveg">
        <h1>Köszöntelek újra a weboldalon!</h1>
    </div>
</div>
<main>
    <section>
        <h1>Bejelentkezés</h1>
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form action="login.php" method="POST">
            <label for="email">Email cím:</label><br>
            <input type="email" name="email" id="email" required><br><br>

            <label for="password">Jelszó:</label><br>
            <input type="password" name="password" id="password" required><br><br>

            <button type="submit">Bejelentkezés</button>
        </form>
        <p>Még nincs fiókod? <a href="register.php">Regisztrálj itt!</a></p>
    </section>
</main>
<footer>
    <a href="">Impresszum</a>
    <a href="">Jogi nyilatkozat</a>
    <a href="">Cookie-Kezelés</a>
    <a href="">Adatkezelés</a>
</footer>
</body>
</html>
