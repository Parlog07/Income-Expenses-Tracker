<?php
require_once "../Includes/auth.php";
require_once "../Includes/db.php";

$user_id = $_SESSION['user_id'];

// Fetch cards
$stmt = $pdo->prepare("
    SELECT * 
    FROM cards
    WHERE user_id = ?
    ORDER BY is_main DESC, created_at ASC
");
$stmt->execute([$user_id]);
$cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Cards</title>
</head>
<body>

<h2>My Cards</h2>

<?php if (empty($cards)): ?>
    <p>No cards yet.</p>
<?php endif; ?>

<?php foreach ($cards as $card): ?>

    <?php
    // Income for this card
    $stmt = $pdo->prepare("
        SELECT COALESCE(SUM(amount), 0)
        FROM incomes
        WHERE card_id = ? AND user_id = ?
    ");
    $stmt->execute([$card['id'], $user_id]);
    $income = $stmt->fetchColumn();

    // Expense for this card
    $stmt = $pdo->prepare("
        SELECT COALESCE(SUM(amount), 0)
        FROM expenses
        WHERE card_id = ? AND user_id = ?
    ");
    $stmt->execute([$card['id'], $user_id]);
    $expense = $stmt->fetchColumn();

    $balance = $income - $expense;
    ?>

    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px">
        <strong><?= htmlspecialchars($card['name']) ?></strong>

        <?php if ($card['is_main']): ?>
            <span style="color:green; font-weight:bold;">(Main card)</span>
        <?php else: ?>
            <!-- 🔹 STEP 5 — Set as main button -->
            <a 
                href="set-main.php?id=<?= $card['id'] ?>"
                style="margin-left:10px; color:blue; text-decoration:underline;"
                onclick="return confirm('Set this card as main?');"
            >
                Set as main
            </a>
        <?php endif; ?>

        <p>Balance: <?= number_format($balance, 2) ?> MAD</p>
    </div>

<?php endforeach; ?>

</body>
</html>
