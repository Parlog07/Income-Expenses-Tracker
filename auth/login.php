<?php
require_once "../Includes/db.php";
session_start();

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Validation
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

        if (!$user) {
            $errors[] = "Invalid email or password";
        }
    }
    // Verify password
    if (empty($errors)) {
        if (!password_verify($password, $user["password"])) {
            $errors[] = "Invalid email or password";
        }
    }
    // OTP
    if (empty($errors)) {

        // Generate OTP
        $otp = rand(100000, 999999);

        // Store OTP data in session
        $_SESSION["otp"] = $otp;
        $_SESSION["otp_user_id"] = $user["id"];
        $_SESSION["otp_user_name"] = $user["full_name"];
        $_SESSION["otp_expires"] = time() + 300; // 5 minutes

        // Send OTP by email
        mail(
            $user["email"],
            "Your Login OTP Code",
            "Hello {$user['full_name']},\n\nYour OTP code is: $otp\nThis code expires in 5 minutes.\n\nIf this wasn't you, please ignore this email."
        );

        // Redirect to OTP verification page
        header("Location: verify-otp.php");
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
