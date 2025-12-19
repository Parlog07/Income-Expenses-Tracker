<?php
require_once "../Includes/auth.php";
require_once "../Includes/db.php";

$user_id = $_SESSION["user_id"];
?>

<h2>Send Money</h2>

<form method="POST" action="store.php">
    <label>Receiver Email</label><br>
    <input type="email" name="email" required><br><br>

    <label>Amount</label><br>
    <input type="number" name="amount" step="0.01" required><br><br>

    <button type="submit">Send</button>
</form>
