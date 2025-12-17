<?php
session_start();

if (!isset($_SESSION["otp"], $_SESSION["otp_user_id"])) {
    header("Location: login.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $enteredOtp = $_POST["otp"];

    if (time() > $_SESSION["otp_expires"]) {
        $error = "OTP expired. Please login again.";
    } elseif ($enteredOtp == $_SESSION["otp"]) {

        // OTP correct → finalize login
        $_SESSION["user_id"] = $_SESSION["otp_user_id"];

        // Cleanup
        unset($_SESSION["otp"], $_SESSION["otp_user_id"], $_SESSION["otp_expires"]);

        header("Location: ../index.php");
        exit;

    } else {
        $error = "Invalid OTP code.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
</head>
<body>

<h2>Enter OTP</h2>

<?php if ($error): ?>
    <p style="color:red"><?= $error ?></p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="otp" placeholder="6-digit OTP" required>
    <button type="submit">Verify</button>
</form>

</body>
</html>
