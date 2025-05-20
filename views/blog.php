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

<div class="container my-5">
    <main>
        <h1 class="mb-4">Blogbejegyzések</h1>

        <div class="row g-4">
            <?php foreach ($posts as $post): ?>
                <div class="col-md-6 col-lg-4">
                    <article class="card h-100 shadow-sm">
                        <?php if (!empty($post['image'])): ?>
                            <img src="<?= htmlspecialchars($post['image']) ?>" class="card-img-top img-fluid" alt="Bejegyzés képe">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
                            <p class="text-muted small mb-2"><?= date('Y.m.d', strtotime($post['created_at'])) ?></p>
                            <p class="card-text"><?= nl2br(htmlspecialchars(mb_substr($post['content'], 0, 300))) ?>...</p>
                            <a href="index.php?page=post&id=<?= $post['id'] ?>" class="btn btn-primary mt-auto">Tovább olvasom</a>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($isAdmin): ?>
            <hr class="my-5">
            <h3 class="mb-3">Új bejegyzés hozzáadása</h3>
            <form method="POST" enctype="multipart/form-data" class="row g-3">
                <div class="col-12">
                    <label for="title" class="form-label">Cím</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>

                <div class="col-12">
                    <label for="content" class="form-label">Tartalom</label>
                    <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
                </div>

                <div class="col-12">
                    <label for="image" class="form-label">Kép (opcionális)</label>
                    <input type="file" name="image" id="image" class="form-control">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-success">Bejegyzés mentése</button>
                </div>
            </form>
        <?php endif; ?>
    </main>
</div>

