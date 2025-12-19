<?php
require_once "../Includes/auth.php";
require_once "../Includes/db.php";

$user_id = $_SESSION["user_id"];
$name = trim($_POST["name"]);

if ($name === "") {
    header("Location: index.php");
    exit;
}

// First card becomes main automatically
$stmt = $pdo->prepare("
    SELECT COUNT(*) FROM cards WHERE user_id = ?
");
$stmt->execute([$user_id]);
$hasCards = $stmt->fetchColumn();

$is_main = $hasCards == 0 ? 1 : 0;

$stmt = $pdo->prepare("
    INSERT INTO cards (user_id, name, is_main)
    VALUES (?, ?, ?)
");
$stmt->execute([$user_id, $name, $is_main]);

header("Location: index.php");
exit;
