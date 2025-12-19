<?php
require_once "../Includes/auth.php";
require_once "../Includes/db.php";

$name = trim($_POST['name'] ?? '');
$is_main = isset($_POST['is_main']) ? 1 : 0;
$user_id = $_SESSION['user_id'];

if ($name === '') {
    header("Location: index.php?error=Name required");
    exit;
}

if ($is_main) {
    $stmt = $pdo->prepare("
        UPDATE cards 
        SET is_main = 0 
        WHERE user_id = ?
    ");
    $stmt->execute([$user_id]);
}

$stmt = $pdo->prepare("
    INSERT INTO cards (user_id, name, is_main)
    VALUES (?, ?, ?)
");
$stmt->execute([$user_id, $name, $is_main]);

header("Location: index.php");
exit;
