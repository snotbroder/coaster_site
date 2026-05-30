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
define("search_min", 0);
define("search_max", 40);
function _validate_search()
{
    $search = $_POST["search"] ?? $_GET["filter_search"] ?? ""; //I have to use POST because it wont work with mixhtml. filter_search is for page-map
    $search = trim($search);
    if (strlen($search) < search_min) {
        throw new Exception("Search must be at least " . search_min . " characters long", 400);
    }
    if (strlen($search) > search_max) {
        throw new Exception("Search must be max " . search_max . " characters long", 400);
    }
    return htmlspecialchars($search);
}

// ##############################
define("user_username_min", 2);
define("user_username_max", 20);
function _validate_user_username()
{

    $user_username = $_POST["user_username"] ?? "";
    $user_username = trim($user_username);
    if (strlen($user_username) < user_username_min) {
        throw new Exception("Username min " . user_username_min . " characters", 400);
    }
    if (strlen($user_username) > user_username_max) {
        throw new Exception("Username max " . user_username_max . " characters", 400);
    }
    return $user_username;
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
define("review_body_min", 5);
define("review_body_max", 500);
function _validate_review_body()
{
    $review_body = $_POST["review_body"] ?? "";
    $review_body = trim($review_body);
    if (strlen($review_body) < review_body_min) {
        throw new Exception("Review must be at least " . review_body_min . " characters long", 400);
    }
    if (strlen($review_body) > review_body_max) {
        throw new Exception("Review must be max " . review_body_max . " characters long", 400);
    }
    return $review_body;
}


// ############################## Got help from Claude
function timeago($timestamp): void
{
    $seconds = time() - (int)$timestamp;
    $minutes = intdiv($seconds, 60);
    $hours   = intdiv($minutes, 60);
    $days    = intdiv($hours, 24);
    $weeks   = intdiv($days, 7);
    $months  = intdiv($days, 30);
    $years   = intdiv($days, 365);

    if ($seconds < 60)  $result = "just now";
    elseif ($minutes < 60)  $result = "$minutes minute"  . ($minutes > 1 ? "s" : "") . " ago";
    elseif ($hours < 24)    $result = "$hours hour"       . ($hours   > 1 ? "s" : "") . " ago";
    elseif ($days < 7)      $result = "$days day"         . ($days    > 1 ? "s" : "") . " ago";
    elseif ($weeks < 4)     $result = "$weeks week"       . ($weeks   > 1 ? "s" : "") . " ago";
    elseif ($months < 12)   $result = "$months month"     . ($months  > 1 ? "s" : "") . " ago";
    else                    $result = "$years year"       . ($years   > 1 ? "s" : "") . " ago";

    echo htmlspecialchars($result);
}


// ############################## Help from Claude, inspired by https://www.geeksforgeeks.org/html/write-a-code-to-upload-a-file-in-php/
define("avatar_max_bytes", 2 * 1024 * 1024); // 2MB
define("avatar_max_bytes_string", "2MB");
function _validate_user_avatar(): array
{

    $file = $_FILES["user_avatar"] ?? null;

    if (!$file || $file["error"] === UPLOAD_ERR_NO_FILE) {
        throw new Exception("No file uploaded", 400);
    }
    if ($file["error"] !== UPLOAD_ERR_OK) {
        throw new Exception("Upload failed (error " . $file["error"] . ")", 400);
    }
    if ($file["size"] > avatar_max_bytes) {
        throw new Exception("File too large, max 2MB", 400);
    }

    $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    if (!in_array($ext, ["jpg", "jpeg", "png", "webp"])) {
        throw new Exception("Invalid file type. Allowed: jpg, jpeg, png, webp", 400);
    }

    // Check actual file content, not just the extension
    $mime = mime_content_type($file["tmp_name"]);
    if (!in_array($mime, ["image/jpeg", "image/png", "image/jpg", "image/webp"])) {
        throw new Exception("File content does not match a supported image type", 400);
    }

    return $file;
}

// ##############################
function _no_cache(): void
{
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");
    header('Clear-Site-Data: "cache", "cookies", "storage", "executionContexts"');
}
