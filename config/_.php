<?php

// ##############################
function _($text)
{
    echo htmlspecialchars($text);
}

// ##############################
// Stolen from https://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid
function uuidv4_nodash()
{
    $data = random_bytes(16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

    return vsprintf('%s%s%s%s%s%s%s%s', str_split(bin2hex($data), 4));
}

// ##############################
define("search_min", 1);
define("search_max", 40);
function _validate_search()
{
    $search = $_POST["search"] ?? "";
    $search = trim($search);
    if (strlen($search) < search_min) {
        throw new Exception("Search must be at least " . search_min . " characters long", 400);
    }
    if (strlen($search) > search_max) {
        throw new Exception("Search must be max " . search_max . " characters long", 400);
    }
    return $search;
}


// ##############################
define("user_email_min", 5);
define("user_email_max", 50);
function _validate_user_email()
{
    $user_email = $_POST["user_email"] ??  "";
    $user_email = trim($user_email);
    if (strlen($user_email) < user_email_min) {
        throw new Exception("Email must be at least " . user_email_min . " characters long", 400);
    }
    if (strlen($user_email) > user_email_max) {
        throw new Exception("Email must be max " . user_email_max . " characters long", 400);
    }
    if (! filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email $user_email", 400);
    }
    // Generated with claude
    if (!preg_match('/^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/', $user_email)) {
        throw new Exception("Email format not allowed", 400);
    }
    return $user_email;
}

// ##############################
define("user_password_min", 6);
define("user_password_max", 20);
function _validate_user_password()
{

    $user_password = $_POST["user_password"] ?? "";
    $user_password = trim($user_password);
    if (strlen($user_password) < user_password_min) {
        throw new Exception("Password min " . user_password_min . " characters", 400);
    }
    if (strlen($user_password) > user_password_max) {
        throw new Exception("Password max " . user_password_max . " characters", 400);
    }
    return $user_password;
}

// ##############################
function _no_cache()
{
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");
    header('Clear-Site-Data: "cache", "cookies", "storage", "executionContexts"');
}
