<?php
try {
    session_start();
    require_once ROOT . "/config/_.php";
    require_once ROOT . "/config/db.php";

    //Get data from form
    $user_login = $_POST["user_login"] ?? "";
    $user_password = $_POST["user_password"] ?? "";

    //Validate
    $user_password = _validate_user_password();

    if (filter_var($user_login, FILTER_VALIDATE_EMAIL)) {
        $_POST["user_email"] = $user_login;
        $user_email = _validate_user_email();
        $stmt = $_db->prepare("SELECT * FROM users WHERE user_email = :login");
    } else {
        $_POST["user_username"] = $user_login;
        $user_username = _validate_user_username();
        $stmt = $_db->prepare("SELECT * FROM users WHERE user_username = :login");
    }
    //fetch data from with credentials
    $stmt->execute([":login" => $user_login]);
    $user = $stmt->fetch();

    // If user isnt found, display error toast
    if (!$user || !password_verify($user_password, $user["user_password"])) {
        http_response_code(401);
        $message = "Invalid email or password.";
?>
        <browser mix-update="#toast-container">
            <?php require_once ROOT . "/views/components/__toast_error.php" ?>
        </browser>
    <?php
        exit;
    }

    // Check if user is deactivated
    $user_pk = $user["user_pk"];
    $stmt = $_db->prepare("SELECT 1 FROM users WHERE user_pk = :user_pk AND user_deleted_at > 0");
    $stmt->execute([":user_pk" => $user_pk]);
    if ($stmt->fetch()) {
        http_response_code(409);
        $message = "User inactive, contact moderator";
    ?>
        <browser mix-update="#toast-container">
            <?php require_once ROOT . "/views/components/__toast_error.php" ?>
        </browser>
    <?php
        exit;
    }

    // Initialize session, store user email
    $_SESSION["user_username"] = $user["user_username"];
    $_SESSION["user_email"] = $user["user_email"];
    $_SESSION["user_avatar_path"] = $user["user_avatar_path"];
    $_SESSION["user_authority"] = $user["user_authority"];

    // redirect to index
    ?>
    <browser mix-redirect="/"></browser>
<?php
} catch (Exception $e) {
    http_response_code($e->getCode());
    $message = $e->getMessage();
?>
    <browser mix-update="#toast-container">
        <?php require_once ROOT . "/views/components/__toast_error.php" ?>
    </browser>
<?php
}
?>