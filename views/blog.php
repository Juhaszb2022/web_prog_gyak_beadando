<?php
require_once './includes/db.php';
require_once './includes/auth.php';  

$posts = $db->query("SELECT * FROM posts ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);


$isAdmin = isset($_SESSION['user_id']) && isAdmin($_SESSION['user_id']);  


if ($isAdmin && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['content'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];


    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageName = basename($_FILES['image']['name']);
        $imagePath = 'uploads/' . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        $image = $imagePath;
    }

    $stmt = $db->prepare("INSERT INTO posts (title, content, created_at, author_id, image) VALUES (?, ?, NOW(), ?, ?)");
    $stmt->execute([$title, $content, $_SESSION['user_id'], $image]);
    header("Location: /.views/blog.php");
    exit;
}
?>

<main class="blog-list">
    <?php foreach ($posts as $post): ?>
        <article class="blog-post">
            <h2 class="post-title"><?= htmlspecialchars($post['title']) ?></h2>
            <p class="post-date"><?= date('Y.m.d', strtotime($post['created_at'])) ?></p>
            <div class="post-image">
                <?php if ($post['image']): ?>
                    <img src="<?= htmlspecialchars($post['image']) ?>" alt="Bejegyzés képe">
                <?php endif; ?>
            </div>
            <p class="post-content"><?= nl2br(htmlspecialchars(substr($post['content'], 0, 300))) ?>...</p>
            <a href="./views/post.php?id=<?= $post['id'] ?>" class="read-more">Tovább olvasom</a>
        </article>
    <?php endforeach; ?>

    <?php if ($isAdmin): ?>

        <button onclick="document.getElementById('create-post-form').style.display='block'">Új bejegyzés hozzáadása</button>


        <div id="create-post-form" style="display:none;">
            <h3>Új bejegyzés</h3>
            <form action="index.php" method="POST" enctype="multipart/form-data">
                <label for="title">Cím:</label>
                <input type="text" name="title" required><br><br>

                <label for="content">Tartalom:</label>
                <textarea name="content" required></textarea><br><br>

                <label for="image">Kép feltöltése (nem kötelező):</label>
                <input type="file" name="image"><br><br>

                <button type="submit">Bejegyzés közzététele</button>
            </form>
        </div>
    <?php endif; ?>
</main>
