<?php
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $inputOtp = $_POST["otp"] ?? "";

    if (
        isset($_SESSION["otp"], $_SESSION["otp_expires"], $_SESSION["otp_user_id"]) &&
        time() <= $_SESSION["otp_expires"] &&
        $inputOtp == $_SESSION["otp"]
    ) {
        $_SESSION["user_id"] = $_SESSION["otp_user_id"];

        unset($_SESSION["otp"], $_SESSION["otp_expires"], $_SESSION["otp_user_id"]);

        header("Location: ../index.php");
        exit;
    } else {
        $error = "Invalid or expired OTP";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
</head>
<body>

<h2>Verify OTP</h2>

<?php if ($error): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="otp" placeholder="Enter OTP" required><br><br>
    <button type="submit">Verify</button>
</form>

</body>
</html>
