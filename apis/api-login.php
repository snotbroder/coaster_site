<?php
try {
    session_start();
    require_once ROOT . "/config/_.php";
    require_once ROOT . "/config/db.php";

    //Get data from form
    $user_email = $_POST["user_email"] ?? "";
    $user_password = $_POST["user_password"] ?? "";

    //Validate
    $user_email = _validate_user_email();
    $user_password = _validate_user_password();

    //fetch data from db
    $stmt = $_db->prepare("SELECT * FROM users WHERE user_email = :email");
    $stmt->execute([":email" => $user_email]);
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
    $stmt = $_db->prepare("SELECT 1 FROM users WHERE user_email = :email AND user_deleted_at > 0");
    $stmt->execute([":email" => $user_email]);
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
    $_SESSION["user_email"] = $user["user_email"];

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