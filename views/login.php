<?php
require_once __DIR__ .'/../includes/db.php';
require_once __DIR__ .'/../includes/auth.php';

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
        header("Location: index.php?page=home");
        exit;
    } else {
        $error = "Hibás email vagy jelszó.";
    }
}
?>

<main class="container mt-5">
    <section class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h1 class="text-center mb-4">Bejelentkezés</h1>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="views/login.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email cím:</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Jelszó:</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Bejelentkezés</button>
            </form>

            <p class="text-center mt-3">
                Még nincs fiókod? <a href="index.php?page=register">Regisztrálj itt!</a>
            </p>
        </div>
    </section>
</main>

