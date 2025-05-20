<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

$hiba = '';
$siker = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $uzenet = trim($_POST['uzenet'] ?? '');
    $felhasznalo = isLoggedIn() ? getLoggedInUsername($db) : 'vendég';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $hiba = 'Hibás email formátum.';
    } elseif (strlen($uzenet) < 30) {
        $hiba = 'Az üzenetnek legalább 30 karakteresnek kell lennie.';
    } else {
        $stmt = $db->prepare("INSERT INTO report (email, felhasznalo, uzenet, datum) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$email, $felhasznalo, $uzenet]);
        $siker = 'Hiba jelentés elküldve.';
    }
}
?>

<div class="content">
    <h1>Hiba bejelentő</h1>

    <?php if ($hiba): ?>
        <p style="color: red;"><?= htmlspecialchars($hiba) ?></p>
    <?php elseif ($siker): ?>
        <p style="color: green;"><?= htmlspecialchars($siker) ?></p>
    <?php endif; ?>

    <form method="POST" onsubmit="return validateForm();">
        <label for="email">Email cím:</label><br>
        <input type="email" name="email" id="email" required><br><br>

        <label for="uzenet">Üzenet:</label><br>
        <textarea name="uzenet" id="uzenet" rows="6" required></textarea><br><br>

        <button type="submit">Küldés</button>
    </form>
</div>

<script>
function validateForm() {
    const email = document.getElementById('email').value;
    const uzenet = document.getElementById('uzenet').value;

    if (!email.includes('@') || !email.includes('.')) {
        alert("Adj meg egy érvényes email címet.");
        return false;
    }

    if (uzenet.length < 30) {
        alert("Az üzenet túl rövid. Legalább 30 karakter kell.");
        return false;
    }

    return true;
}
</script>
