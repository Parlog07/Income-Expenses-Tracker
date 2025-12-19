<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'ayoubmogador2014@gmail.com';
    $mail->Password = 'uxxzggzgmktbovig'; // App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('ayoubmogador2014@gmail.com', 'PHPMailer Test');
    $mail->addAddress('ayoubmogador2014@gmail.com');

    $mail->Subject = 'Test Email';
    $mail->Body    = 'PHPMailer is working 🎉';
    $mail->SMTPOptions = [
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true,
    ],
];

    $mail->send();
    echo '✅ Email sent successfully';
} catch (Exception $e) {
    echo '❌ Error: ' . $mail->ErrorInfo;
}
