<?php
include "../Includes/db.php";
$id = $_GET["id"];
$stmt = $pdo->prepare("SELECT * FROM expenses WHERE id = ?");
$stmt->execute([$id]);
$expense = $stmt->fetch();
?>
<form method="POST" action="update.php?id=<?= $id ?>">
    <input name="amount" value="<?= $expense['amount'] ?>">
    <input name="description" value="<?= $expense['description'] ?>">
    <input name="date" type="date" value="<?= $expense['date'] ?>">
    <button>Update</button>
</form>
