<?php
require_once './includes/db.php';
require_once './includes/auth.php';

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

            header("Location: index.php?page=home");
            exit;
        }
    }
}
?>

<main>
    <section>
        <h1>Regisztráció</h1>
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form action="views/register.php" method="POST">
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
        <p>Már van fiókod? <a href="index.php?page=login">Jelentkezz be!</a></p>
    </section>
</main>

