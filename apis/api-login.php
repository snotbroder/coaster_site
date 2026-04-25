<?php
require_once __DIR__ . '/../config/_.php';
$user_email = $_POST['user_email'] ?? '';
$user_password = $_POST['user_password'] ?? '';

// _validate_user_email($user_email);
// _validate_user_password($user_password);

// Initialize session, store user email
// session_start();
// $_SESSION["user_email"] = $user_email;

?>

<div mix-redirect="/">
    <p>User Email: <?= _($user_email) ?>, User Password: <?= _($user_password) ?></p>
</div>