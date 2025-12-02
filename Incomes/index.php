<?php
include "../Includes/db.php";

$stmt = $pdo->prepare("SELECT * FROM incomes");
$stmt->execute();
$incomes = $stmt->fetchAll();
?>

<table>
    <tr>
        <th>ID</th>
        <th>Amount</th>
        <th>Description</th>
        <th>Date</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($incomes as $income) { ?>
        <tr>
            <td><?= $income["id"] ?></td>
            <td><?= $income["amount"] ?></td>
            <td><?= $income["description"] ?></td>
            <td><?= $income["date"] ?></td>
            <td>
            <a href="edit.php?id=<?= $income['id'] ?>">Edit</a>
            <a href="delete.php?id=<?= $income['id'] ?>">Delete</a>
            </td>

        </tr>
    <?php } ?>

</table>

