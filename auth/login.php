<?php
require_once "../Includes/db.php";
session_start();

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user["password"])) {
            $errors[] = "Invalid email or password";
        }
    }


    if (empty($errors)) {

        $otp = random_int(100000, 999999);

        $_SESSION["otp"] = $otp;
        $_SESSION["otp_expires"] = time() + 300; 
        $_SESSION["otp_user_id"] = $user["id"];

        $to = $user["email"];
        $subject = "Your OTP Code";
        $message = "Your OTP code is: $otp\n\nThis code expires in 5 minutes.";
        $headers = "From: Smart Wallet <no-reply@smartwallet.local>";

        mail($to, $subject, $message, $headers);

        header("Location: verify_otp.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<?php if (!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li style="color:red"><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="POST">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Login</button>
</form>

</body>
</html>
