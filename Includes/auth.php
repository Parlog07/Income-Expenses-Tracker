<?php
require_once "Includes/auth.php";

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit;
}
