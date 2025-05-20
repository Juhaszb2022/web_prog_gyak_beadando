<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'templates/header.php';

$id = $_GET['id'] ?? 0;
$stmt = $db->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

$comments = $db->prepare("
    SELECT comments.comment, comments.created_at, users.username
    FROM comments
    INNER JOIN users ON comments.user_id = users.id
    WHERE comments.post_id = ?
    ORDER BY comments.created_at DESC
");
$comments->execute([$id]);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isLoggedIn()) {
    $comment = $_POST['comment'] ?? '';
    $insert = $db->prepare("INSERT INTO comments (post_id, user_id, comment, created_at) VALUES (?, ?, ?, NOW())");
    $insert->execute([$id, $_SESSION['user_id'], $comment]);
    header("Location: post.php?id=$id");
}
?>

<main class="blog-post-full">
    <h2><?= htmlspecialchars($post['title']) ?></h2>
    <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>

    <section class="comments">
        <h3>Hozzászólások</h3>
        <?php while ($c = $comments->fetch()): ?>
            <div class="comment">
                <p><strong><?= htmlspecialchars($c['username']) ?></strong>: <em><?= $c['created_at'] ?></em></p>
                <p><?= nl2br(htmlspecialchars($c['comment'])) ?></p>
            </div>
        <?php endwhile; ?>


        <?php if (isLoggedIn()): ?>
            <form method="POST">
                <textarea name="comment" required></textarea>
                <button type="submit">Hozzászólás beküldése</button>
            </form>
        <?php else: ?>
            <p><a href="login.php">Jelentkezz be</a> a hozzászóláshoz!</p>
        <?php endif; ?>
    </section>
</main>

<?php require_once 'templates/footer.php'; ?>