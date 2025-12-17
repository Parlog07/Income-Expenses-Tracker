<?php
require_once "../Includes/auth.php";
require_once "../Includes/db.php";

$user_id = $_SESSION["user_id"];
$amount = $_POST["amount"];
$description = $_POST["description"];
$date = $_POST["date"];
$stmt = $pdo->prepare("INSERT INTO expenses (amount, description, date, user_id) VALUES (?, ?, ?, ?)");
$stmt->execute([
    $amount,
    $description,
    $date,
    $user_id
]);

header("Location: index.php");
exit;