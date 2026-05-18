<?php

try {
    require_once ROOT . "/config/_.php";
    require_once ROOT . "/config/db.php";

    //Prepare data
    $user_pk = uuidv4_nodash(); // uuid without dashes
    $user_email = _validate_user_email();
    $user_password = _validate_user_password();
    $user_confirm_password = $_POST['user_confirm_password'] ?? null;
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
    $user_avatar_path = "/static/assets/avatars/profile_avatar_fallback.jpg";
    $user_created_at = time();
    $user_deleted_at = 0;


    // Check if password and confirm password match
    if ($user_password !== $user_confirm_password) {
        http_response_code(400);
        $message = "Passwords do not match";
?>
        <browser mix-update="#toast-container">
            <?php require_once ROOT . "/views/components/__toast_error.php" ?>
        </browser>
    <?php
        exit;
    }

    // Check if email already exists
    $stmt = $_db->prepare("SELECT 1 FROM users WHERE user_email = :email");
    $stmt->execute([":email" => $user_email]);
    if ($stmt->fetch()) {
        http_response_code(409);
        $message = "Email already in use";
    ?>

        <browser mix-update="#toast-container">
            <?php require_once ROOT . "/views/components/__toast_error.php" ?>
        </browser>
    <?php
        exit;
    }

    // Insert user data into database
    $sql = "INSERT INTO users (user_pk, user_email, user_password, user_avatar_path, user_created_at, user_deleted_at) 
    VALUES (:user_pk, :email, :password, :avatar_path, :created_at, :deleted_at)";
    $stmt = $_db->prepare($sql);

    $stmt->execute([
        ":user_pk" => $user_pk,
        ":email" => $user_email,
        ":password" => $hashed_password,
        ":avatar_path" => $user_avatar_path,
        ":created_at" => $user_created_at,
        ":deleted_at" => $user_deleted_at,
    ]);

    _("ok");

    ?>
    <browser mix-redirect="/login">
    </browser>
<?php

    exit();
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