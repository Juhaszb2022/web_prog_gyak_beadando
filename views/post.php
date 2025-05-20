<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

$id = $_GET['id'] ?? 0;
$stmt = $db->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    echo "<p>A bejegyzés nem található.</p>";
    return;
}

$comments = $db->prepare("
    SELECT comments.comment, comments.created_at, users.username
    FROM comments
    INNER JOIN users ON comments.user_id = users.id
    WHERE comments.post_id = ?
    ORDER BY comments.created_at DESC
");
$comments->execute([$id]);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isLoggedIn()) {
    $comment = trim($_POST['comment']);
    if (strlen($comment) > 0) {
        $insert = $db->prepare("INSERT INTO comments (post_id, user_id, comment, created_at) VALUES (?, ?, ?, NOW())");
        $insert->execute([$id, $_SESSION['user_id'], $comment]);
        header("Location: index.php?page=post&id=$id");
        exit;
    }
}
?>

<div class="container my-5">
    <main class="blog-post-full">
        <h2 class="mb-4"><?= htmlspecialchars($post['title']) ?></h2>

        <?php if (!empty($post['image'])): ?>
            <div class="mb-4 text-center">
                <img src="<?= htmlspecialchars($post['image']) ?>" alt="Bejegyzés képe" class="img-fluid rounded shadow-sm" style="max-width: 100%; height: auto; max-height: 500px;">
            </div>
        <?php endif; ?>

        <div class="mb-5">
            <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
        </div>

        <a href="index.php?page=blog" class="btn btn-secondary mb-5">← Vissza a bloghoz</a>

        <section class="comments mt-5">
            <h3 class="mb-4">Hozzászólások</h3>

            <?php while ($c = $comments->fetch()): ?>
                <div class="mb-4 p-3 border rounded bg-light">
                    <p class="mb-1">
                        <strong><?= htmlspecialchars($c['username']) ?></strong>
                        <span class="text-muted small"> – <?= $c['created_at'] ?></span>
                    </p>
                    <p><?= nl2br(htmlspecialchars($c['comment'])) ?></p>
                </div>
            <?php endwhile; ?>

            <?php if (isLoggedIn()): ?>
                <form method="POST" class="mt-4">
                    <div class="mb-3">
                        <label for="comment" class="form-label">Új hozzászólás</label>
                        <textarea name="comment" id="comment" class="form-control" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Hozzászólás beküldése</button>
                </form>
            <?php else: ?>
                <p><a href="index.php?page=login" class="btn btn-outline-primary">Jelentkezz be</a> a hozzászóláshoz!</p>
            <?php endif; ?>
        </section>
    </main>
</div>
