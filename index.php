<?php
include "Includes/db.php";

$stmt = $pdo->prepare("SELECT SUM(amount) AS total_income FROM incomes");
$stmt->execute();
$result = $stmt->fetch();
$total_income = $result["total_income"];

$stmt = $pdo->prepare("SELECT SUM(amount) AS total_expense FROM expenses");
$stmt->execute();
$result = $stmt->fetch();
$total_expense = $result["total_expense"];

$balance = $total_income - $total_expense;

$stmt = $pdo->prepare("
    SELECT SUM(amount) AS monthly_income 
    FROM incomes 
    WHERE MONTH(date) = MONTH(CURRENT_DATE())
    AND YEAR(date) = YEAR(CURRENT_DATE())
");
$stmt->execute();
$result = $stmt->fetch();
$monthly_income = $result["monthly_income"];

$stmt = $pdo->prepare("
    SELECT SUM(amount) AS monthly_expense 
    FROM expenses 
    WHERE MONTH(date) = MONTH(CURRENT_DATE())
    AND YEAR(date) = YEAR(CURRENT_DATE())
");
$stmt->execute();
$result = $stmt->fetch();
$monthly_expense = $result["monthly_expense"];

?>

<h2>Total Income: <?= $total_income ?> </h2>
<h2>Total Expense: <?= $total_expense ?> </h2>
<h2>Balance: <?= $balance ?> </h2>
<h3>Monthly Income: <?= $monthly_income ?></h3>
<h3>Monthly Expense: <?= $monthly_expense ?></h3>
    