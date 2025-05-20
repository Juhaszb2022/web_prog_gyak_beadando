<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

$posts = $db->query("SELECT * FROM posts ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

$isAdmin = isAdmin();

// új poszt mentése
if ($isAdmin && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['content'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    $image = null;
    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
        $uploadDir = __DIR__ . '/../uploads/';
        $imagePath = 'uploads/' . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);
        $image = $imagePath;
    }

    $stmt = $db->prepare("INSERT INTO posts (title, content, created_at, author_id, image) VALUES (?, ?, NOW(), ?, ?)");
    $stmt->execute([$title, $content, $_SESSION['user_id'], $image]);
    header("Location: index.php?page=blog");
    exit;
}
?>

<div class="content">
    <main class="blog-list">
        <h1>Blogbejegyzések</h1>

        <?php foreach ($posts as $post): ?>
            <article class="blog-post">
                <h2><?= htmlspecialchars($post['title']) ?></h2>
                <p class="post-date"><?= date('Y.m.d', strtotime($post['created_at'])) ?></p>

                <?php if (!empty($post['image'])): ?>
                    <div class="post-image">
                        <img src="<?= htmlspecialchars($post['image']) ?>" alt="Bejegyzés képe" style="max-width: 300px;">
                    </div>
                <?php endif; ?>

                <p><?= nl2br(htmlspecialchars(mb_substr($post['content'], 0, 300))) ?>...</p>
                <a href="index.php?page=post&id=<?= $post['id'] ?>" class="read-more">Tovább olvasom</a>
            </article>
        <?php endforeach; ?>

        <?php if ($isAdmin): ?>
            <hr>
            <h3>Új bejegyzés hozzáadása</h3>
            <form method="POST" enctype="multipart/form-data">
                <label>Cím:</label><br>
                <input type="text" name="title" required><br><br>

                <label>Tartalom:</label><br>
                <textarea name="content" required></textarea><br><br>

                <label>Kép (opcionális):</label><br>
                <input type="file" name="image"><br><br>

                <button type="submit">Bejegyzés mentése</button>
            </form>
        <?php endif; ?>
    </main>
</div>
