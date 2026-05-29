<?php

require_once ROOT . "/config/db.php";
require_once ROOT . "/config/_.php";
require_once ROOT . "/config/mail.php";

$email = trim($_POST["email"] ?? "");

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<p mix-update='#forgot_msg' class='text-red-500'>Please enter a valid email address.</p>";
    exit;
}

// Check if user exists
$stmt = $_db->prepare("SELECT user_id FROM users WHERE user_email = :email LIMIT 1");
$stmt->execute([":email" => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Always show the same message to avoid leaking which emails are registered
if (!$user) {
    echo "<p mix-update='#forgot_msg' class='text-green-600'>If that email is registered, you'll receive a reset link shortly.</p>";
    exit;
}

// Generate a secure token and store it
$token = bin2hex(random_bytes(32));
$expires_at = date("Y-m-d H:i:s", strtotime("+1 hour"));

$stmt = $_db->prepare("
    INSERT INTO password_resets (user_id, token, expires_at)
    VALUES (:user_id, :token, :expires_at)
    ON DUPLICATE KEY UPDATE token = :token, expires_at = :expires_at
");
$stmt->execute([
    ":user_id"    => $user["user_id"],
    ":token"      => $token,
    ":expires_at" => $expires_at,
]);

$reset_link = "http://localhost/reset-password?token=" . urlencode($token);

ob_start();
include ROOT . "/static/email/email-forgot-password.php";
$body = ob_get_clean();

send_mail($email, "Reset your CoasterHub password", $body);

echo "<p mix-update='#forgot_msg' class='text-green-600'>If that email is registered, you'll receive a reset link shortly.</p>";
