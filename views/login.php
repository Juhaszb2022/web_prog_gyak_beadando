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
