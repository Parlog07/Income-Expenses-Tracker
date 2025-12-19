<?php
require_once "../Includes/auth.php";
require_once "../Includes/db.php";

$user_id = $_SESSION['user_id'];
$card_id = $_GET['id'] ?? null;

if (!$card_id) {
    die("Card not found");
}

// 1️⃣ Make sure card belongs to user
$stmt = $pdo->prepare("
    SELECT id FROM cards 
    WHERE id = ? AND user_id = ?
");
$stmt->execute([$card_id, $user_id]);

if (!$stmt->fetch()) {
    die("Unauthorized card");
}

// 2️⃣ Remove main from all cards
$stmt = $pdo->prepare("
    UPDATE cards 
    SET is_main = 0 
    WHERE user_id = ?
");
$stmt->execute([$user_id]);

// 3️⃣ Set selected card as main
$stmt = $pdo->prepare("
    UPDATE cards 
    SET is_main = 1 
    WHERE id = ?
");
$stmt->execute([$card_id]);

header("Location: index.php");
exit;
