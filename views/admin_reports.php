<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

if (!isAdmin()) {
    echo "<p>Nincs jogosultságod az oldal megtekintéséhez.</p>";
    exit;
}

$stmt = $db->query("SELECT * FROM report ORDER BY datum DESC");
$jelentesek = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content">
    <h1>Beérkezett hibajelentések</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Felhasználó</th>
                <th>Üzenet</th>
                <th>Dátum</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jelentesek as $sor): ?>
                <tr>
                    <td><?= $sor['id'] ?></td>
                    <td><?= htmlspecialchars($sor['email']) ?></td>
                    <td><?= htmlspecialchars($sor['felhasznalo']) ?></td>
                    <td><?= nl2br(htmlspecialchars($sor['uzenet'])) ?></td>
                    <td><?= $sor['datum'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
