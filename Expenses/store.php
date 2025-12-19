<?php
require_once "../Includes/auth.php";
require_once "../Includes/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request");
}

$user_id = $_SESSION["user_id"];

$card_id     = $_POST["card_id"] ?? null;
$amount      = $_POST["amount"] ?? null;
$description = $_POST["description"] ?? null;
$date        = $_POST["date"] ?? null;

/* =========================
   VALIDATION
   ========================= */
if (!$card_id || !$amount || !$description || !$date) {
    die("Invalid expense data");
}

/* =========================
   INSERT EXPENSE
   ========================= */
$stmt = $pdo->prepare("
    INSERT INTO expenses (user_id, card_id, amount, description, date)
    VALUES (?, ?, ?, ?, ?)
");

$stmt->execute([
    $user_id,
    $card_id,
    $amount,
    $description,
    $date
]);

header("Location: index.php");
exit;
