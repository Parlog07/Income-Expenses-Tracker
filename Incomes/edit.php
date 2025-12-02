<?php
include "../Includes/db.php";
$id = $_GET["id"];
$stmt = $pdo->prepare("SELECT * FROM incomes WHERE id = ?");
$stmt->execute([$id]);
$income = $stmt->fetch();
?>
<form method="POST" action="update.php?id=<?= $id ?>">
    <input name="amount" value="<?= $income['amount'] ?>">
    <input name="description" value="<?= $income['description'] ?>">
    <input name="date" type="date" value="<?= $income['date'] ?>">
    <button>Update</button>
</form>
