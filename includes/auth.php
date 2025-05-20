<?php
function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function isAdmin(): bool {
    return isset($_SESSION['user_id']) && ($_SESSION['is_admin'] ?? 0) == 1;}

    function getLoggedInUsername(PDO $db): string {
        if (!isLoggedIn()) return '';
        $stmt = $db->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetchColumn() ?: '';}
?>
