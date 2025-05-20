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

<div class="content">
    <main class="blog-post-full">
        <h2><?= htmlspecialchars($post['title']) ?></h2>
        <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>

        <?php if (!empty($post['image'])): ?>
            <div class="post-image">
                <img src="<?= htmlspecialchars($post['image']) ?>" alt="Bejegyzés képe" style="max-width: 400px;">
            </div>
        <?php endif; ?>

        <a href="index.php?page=blog"><button>← Vissza a bloghoz</button></a>

        <section class="comments">
            <h3>Hozzászólások</h3>
            <?php while ($c = $comments->fetch()): ?>
                <div class="comment">
                    <p><strong><?= htmlspecialchars($c['username']) ?></strong> – <em><?= $c['created_at'] ?></em></p>
                    <p><?= nl2br(htmlspecialchars($c['comment'])) ?></p>
                </div>
            <?php endwhile; ?>

            <?php if (isLoggedIn()): ?>
                <form method="POST">
                    <textarea name="comment" required></textarea>
                    <button type="submit">Hozzászólás beküldése</button>
                </form>
            <?php else: ?>
                <p><a href="index.php?page=login">Jelentkezz be</a> a hozzászóláshoz!</p>
            <?php endif; ?>
        </section>
    </main>
</div>
