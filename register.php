<?php
session_start();
require_once 'blog/includes/db.php';
require_once 'blog/includes/auth.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($password !== $confirm) {
        $error = "A jelszavak nem egyeznek.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Érvénytelen email-cím.";
    } else {
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);

        if ($stmt->fetch()) {
            $error = "Ez a felhasználónév vagy email már foglalt.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insert = $db->prepare("INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, 0)");

            $insert->execute([$username, $email, $hashedPassword]);

            // Bejelentkezés regisztráció után
            $_SESSION['user_id'] = $db->lastInsertId();
            $_SESSION['is_admin'] = 0;

            header("Location: index.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció - Vaszilij EDC</title>
    <link rel="stylesheet" href="./stlye.css">
</head>
<body>
<header>
    <nav>
        <a href="/web_prog_gyak_beadando/index.php">Kezdőlap</a>
        <a href="blog/index.php">Blog</a>
        <a href="/web_prog_gyak_beadando/shop.php">Ha Kést szeretnél</a>
    </nav>
</header>
<div class="parallax">
    <div class="overlay-szoveg">
        <h1>Üdvözöllek a weboldalon!</h1>
    </div>
</div>
<main>
    <section>
        <h1>Regisztráció</h1>
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form action="register.php" method="POST">
            <label for="username">Felhasználónév:</label><br>
            <input type="text" name="username" id="username" required><br><br>

            <label for="email">Email cím:</label><br>
            <input type="email" name="email" id="email" required><br><br>

            <label for="password">Jelszó:</label><br>
            <input type="password" name="password" id="password" required><br><br>

            <label for="confirm_password">Jelszó újra:</label><br>
            <input type="password" name="confirm_password" id="confirm_password" required><br><br>

            <button type="submit">Regisztráció</button>
        </form>
        <p>Már van fiókod? <a href="login.php">Jelentkezz be!</a></p>
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
