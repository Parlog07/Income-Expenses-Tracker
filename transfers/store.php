<?php
require_once "../Includes/auth.php";
require_once "../Includes/db.php";

$sender_id = $_SESSION["user_id"];
$email = trim($_POST["email"]);
$amount = $_POST["amount"];

if (!$email || !$amount || $amount <= 0) {
    die("Invalid input");
}


$stmt = $pdo->prepare("
    SELECT id 
    FROM users 
    WHERE email = ?
");
$stmt->execute([$email]);
$receiver = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$receiver) {
    die("Receiver not found");
}

$receiver_id = $receiver["id"];

if ($receiver_id == $sender_id) {
    die("You cannot send money to yourself");
}

$stmt = $pdo->prepare("
    SELECT id 
    FROM cards 
    WHERE user_id = ? AND is_main = 1
");
$stmt->execute([$sender_id]);
$senderCard = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$senderCard) {
    die("You must have a main card");
}


$stmt = $pdo->prepare("
    SELECT id 
    FROM cards 
    WHERE user_id = ? AND is_main = 1
");
$stmt->execute([$receiver_id]);
$receiverCard = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$receiverCard) {
    die("Receiver has no main card");
}

$stmt = $pdo->prepare("
    INSERT INTO expenses (amount, description, date, user_id, card_id)
    VALUES (?, ?, CURDATE(), ?, ?)
");
$stmt->execute([
    $amount,
    "Transfer to $email",
    $sender_id,
    $senderCard["id"]
]);


$stmt = $pdo->prepare("
    INSERT INTO incomes (amount, description, date, user_id, card_id)
    VALUES (?, ?, CURDATE(), ?, ?)
");
$stmt->execute([
    $amount,
    "Transfer from user",
    $receiver_id,
    $receiverCard["id"]
]);


$stmt = $pdo->prepare("
    INSERT INTO transfers (sender_id, receiver_id, amount)
    VALUES (?, ?, ?)
");
$stmt->execute([$sender_id, $receiver_id, $amount]);

header("Location: index.php?success=1");
exit;
