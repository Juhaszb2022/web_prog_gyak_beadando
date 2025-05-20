<?php
require_once __DIR__ .'/../includes/db.php';
require_once __DIR__ .'/../includes/auth.php';

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

            header("Location: index.php?page=login");
            exit;
        }
    }
}
?>

<main class="container mt-5">
    <section class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h1 class="text-center mb-4">Regisztráció</h1>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="views/register.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Felhasználónév:</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email cím:</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Jelszó:</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Jelszó újra:</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success w-100">Regisztráció</button>
            </form>

            <p class="text-center mt-3">
                Már van fiókod? <a href="index.php?page=login">Jelentkezz be!</a>
            </p>
        </div>
    </section>
</main>

