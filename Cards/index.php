<?php
require_once "../Includes/auth.php";
require_once "../Includes/db.php";
include "../Includes/layout.php";

$user_id = $_SESSION["user_id"];

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

<h2 class="text-2xl font-bold mb-6">My Cards</h2>

<!-- ADD CARD FORM -->
<div class="bg-white p-6 rounded shadow mb-8">
    <h3 class="text-lg font-bold mb-4">Add New Card</h3>

    <form method="POST" action="store.php" class="flex gap-4">
        <input
            type="text"
            name="name"
            placeholder="Card name (e.g. CIH, PayPal)"
            required
            class="border p-2 rounded w-64"
        >
        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Add
        </button>
    </form>
</div>

<!-- CARD LIST -->
<?php if (empty($cards)): ?>
    <p>No cards yet.</p>
<?php endif; ?>

<?php foreach ($cards as $card): ?>
    <div class="bg-white p-4 rounded shadow mb-4 flex justify-between items-center">
        <div>
            <strong><?= htmlspecialchars($card["name"]) ?></strong>
            <?php if ($card["is_main"]): ?>
                <span class="text-green-600 ml-2">(Main)</span>
            <?php endif; ?>
        </div>

        <div class="flex gap-3">
            <?php if (!$card["is_main"]): ?>
                <a href="set_main.php?id=<?= $card['id'] ?>"
                   class="text-blue-600 hover:underline">
                   Set as main
                </a>
            <?php endif; ?>

            <a href="delete.php?id=<?= $card['id'] ?>"
               onclick="return confirm('Delete this card?')"
               class="text-red-600 hover:underline">
               Delete
            </a>
        </div>
    </div>
<?php endforeach; ?>

</main>
</body>
</html>
