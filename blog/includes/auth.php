<?php
function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function isAdmin(): bool {
    return isset($_SESSION['user_id']) && ($_SESSION['is_admin'] ?? 0) == 1;}
?>