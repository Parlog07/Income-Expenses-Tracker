<?php
include "Includes/db.php";

// TOTAL INCOME
$stmt = $pdo->prepare("SELECT SUM(amount) AS total_income FROM incomes");
$stmt->execute();
$total_income = $stmt->fetch()["total_income"] ?? 0;

// TOTAL EXPENSE
$stmt = $pdo->prepare("SELECT SUM(amount) AS total_expense FROM expenses");
$stmt->execute();
$total_expense = $stmt->fetch()["total_expense"] ?? 0;

// BALANCE
$balance = $total_income - $total_expense;

// MONTHLY INCOME
$stmt = $pdo->prepare("
    SELECT SUM(amount) AS monthly_income 
    FROM incomes 
    WHERE MONTH(date) = MONTH(CURRENT_DATE()) 
    AND YEAR(date) = YEAR(CURRENT_DATE())
");
$stmt->execute();
$monthly_income = $stmt->fetch()["monthly_income"] ?? 0;

// MONTHLY EXPENSE
$stmt = $pdo->prepare("
    SELECT SUM(amount) AS monthly_expense 
    FROM expenses 
    WHERE MONTH(date) = MONTH(CURRENT_DATE()) 
    AND YEAR(date) = YEAR(CURRENT_DATE())
");
$stmt->execute();
$monthly_expense = $stmt->fetch()["monthly_expense"] ?? 0;

include "Includes/layout.php";
?>

<!-- DASHBOARD HEADER -->
<h1 class="text-3xl font-bold mb-8">Dashboard Overview</h1>

<!-- MAIN CARDS -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

    <!-- Total Income -->
    <div class="bg-white rounded-xl p-6 shadow border-l-4 border-green-500">
        <h2 class="text-sm text-gray-500">Total Income</h2>
        <p class="text-3xl font-bold mt-2 text-green-600"><?= number_format($total_income, 2) ?> MAD</p>
    </div>

    <!-- Total Expense -->
    <div class="bg-white rounded-xl p-6 shadow border-l-4 border-red-500">
        <h2 class="text-sm text-gray-500">Total Expense</h2>
        <p class="text-3xl font-bold mt-2 text-red-600"><?= number_format($total_expense, 2) ?> MAD</p>
    </div>

    <!-- Balance -->
    <div class="bg-white rounded-xl p-6 shadow border-l-4 <?= $balance >= 0 ? 'border-blue-500' : 'border-red-500' ?>">
        <h2 class="text-sm text-gray-500">Current Balance</h2>
        <p class="text-3xl font-bold mt-2 <?= $balance >= 0 ? 'text-blue-600' : 'text-red-600' ?>">
            <?= number_format($balance, 2) ?> MAD
        </p>
    </div>
</div>

<!-- MONTHLY SUMMARY -->
<h2 class="text-xl font-bold mb-4">This Month</h2>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

    <div class="bg-white rounded-xl p-6 shadow border border-gray-200">
        <h3 class="text-gray-500 text-sm">Monthly Income</h3>
        <p class="text-2xl font-bold text-green-600 mt-2">
            <?= number_format($monthly_income, 2) ?> MAD
        </p>
    </div>

    <div class="bg-white rounded-xl p-6 shadow border border-gray-200">
        <h3 class="text-gray-500 text-sm">Monthly Expense</h3>
        <p class="text-2xl font-bold text-red-600 mt-2">
            <?= number_format($monthly_expense, 2) ?> MAD
        </p>
    </div>
</div>

<!-- FUTURE CHART PLACEHOLDER -->
<div class="bg-white rounded-xl p-10 shadow text-center border border-gray-200">
    <h3 class="text-lg font-semibold mb-2 text-gray-700">Financial Chart (Coming Soon)</h3>
    <p class="text-gray-500">We will add a beautiful graph here using Chart.js.</p>
</div>

</main>
</body>
</html>
