<?php
// db.php

// $host = 'veebeckz.tech'; // Change if hosting on a different server
// $db = 'u500921674_veebeckz'; // Your database name
// $user = 'u500921674_veebeckz'; // Your database username
// $pass = 'OnGod@123'; // Your database password


$host = 'localhost'; // Change if hosting on a different server
$db = 'veebeckz'; // Your database name
$user = 'root'; // Your database username
$pass = ''; // Your database password
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

