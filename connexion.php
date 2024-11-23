<?php
$pdo = null;
try {
    $pdo = new PDO("mysql:host=localhost;dbname=projetf", "root", "root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
