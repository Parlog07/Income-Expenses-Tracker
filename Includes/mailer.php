<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . "/PHPMailer/Exception.php";
require_once __DIR__ . "/PHPMailer/PHPMailer.php";
require_once __DIR__ . "/PHPMailer/SMTP.php";

function sendOtpEmail($toEmail, $toName, $otp)
{
    $mail = new PHPMailer(true);

    try {
        // SMTP SETTINGS (GMAIL)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'YOUR_GMAIL@gmail.com';     // 🔴 change this
        $mail->Password   = 'YOUR_APP_PASSWORD';        // 🔴 change this
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // EMAIL SETTINGS
        $mail->setFrom('YOUR_GMAIL@gmail.com', 'Smart Wallet');
        $mail->addAddress($toEmail, $toName);

        $mail->isHTML(true);
        $mail->Subject = 'Your Login OTP Code';
        $mail->Body    = "
            <h2>Smart Wallet</h2>
            <p>Hello <strong>$toName</strong>,</p>
            <p>Your OTP code is:</p>
            <h1>$otp</h1>
            <p>This code expires in 5 minutes.</p>
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        // For debugging (temporary)
        error_log("Mail error: " . $mail->ErrorInfo);
        return false;
    }
}
