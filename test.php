<?php
require_once "Includes/mailer.php";

if (sendOTPEmail("ayoubmogador2014@gmail.com", "654321")) {
    echo "MAIL SENT ✅";
} else {
    echo "MAIL FAILED ❌";
}
