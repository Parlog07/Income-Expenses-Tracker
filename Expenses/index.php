<?php
include "../Includes/db.php";

$stmt = $pdo->prepare("SELECT * FROM expenses");
$stmt->execute();
$expenses = $stmt->fetchAll();
?>

<table>
    <tr>
        <th>ID</th>
        <th>Amount</th>
        <th>Description</th>
        <th>Date</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($expenses as $expense) { ?>
        <tr>
            <td><?= $expense["id"] ?></td>
            <td><?= $expense["amount"] ?></td>
            <td><?= $expense["description"] ?></td>
            <td><?= $expense["date"] ?></td>
            <td>
                <a href="edit.php?id=<?= $expense['id'] ?>">Edit</a>
                <a href="delete.php?id=<?= $expense['id'] ?>">Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>
