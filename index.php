<?php
session_start();

// Menü betöltése (ne írd bele a változóba!)
//require_once 'includes/nav.php';

// Oldal kiválasztása az URL alapján
$page = $_GET['page'] ?? 'home';

// Elérhető oldalak
$allowed = ['home', 'blog', 'shop', 'login', 'register'];

if (!in_array($page, $allowed)) {
    $page = 'home';
}

// Fejléc
include 'templates/header.php';

// Tartalom
include "views/{$page}.php";

// Lábjegyzet
include 'templates/footer.php';
