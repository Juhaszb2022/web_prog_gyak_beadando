<?php
$host = 'localhost';        
$dbname = 'vaszilij_blog'; 
$user = 'root';             
$pass = '';                 

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Adatbázis kapcsolat sikertelen: " . $e->getMessage());
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
