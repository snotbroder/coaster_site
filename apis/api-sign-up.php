<?php

try {
    require_once __DIR__ . "../../config/_.php";
    require_once __DIR__ . "../../config/db.php";

    //Prepare data
    $user_email = _validate_user_email();
    $user_password = _validate_user_password();
    $user_confirm_password = $_POST['user_confirm_password'] ?? null;
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
    $user_pk = bin2hex(random_bytes(25)); // Returns 50 characters
    $user_created_at = time();
    $user_deleted_at = 0;

    // Check if password and confirm password match
    if ($user_password !== $user_confirm_password) {
        http_response_code(400);
?>
        <div mix-update="#toast-container">
            <p>Passwords do not match</p>
        </div>
    <?php
        exit;
    }

    // Check if email already exists
    $stmt = $_db->prepare("SELECT 1 FROM users WHERE user_email = :email");
    $stmt->execute([":email" => $user_email]);
    if ($stmt->fetch()) {
        http_response_code(409);
    ?>
        <div mix-update="#toast-container">
            <p>Email already exists</p>
        </div>
    <?php
        exit;
    }

    // Insert user data into database
    $sql = "INSERT INTO users (user_pk, user_email, user_password, user_created_at, user_deleted_at) 
    VALUES (:user_pk, :email, :password, :created_at, :deleted_at)";
    $stmt = $_db->prepare($sql);

    $stmt->bindValue(":user_pk", $user_pk);
    $stmt->bindValue(":email", $user_email);
    $stmt->bindValue(":password", $hashed_password);
    $stmt->bindValue(":created_at", $user_created_at);
    $stmt->bindValue(":deleted_at", $user_deleted_at);

    $stmt->execute();

    _("ok");

    ?>
    <div mix-redirect="/login">
    </div>
    <?php

    exit();
} catch (Exception $e) {

    if (str_contains($e, "Duplicate entry") && str_contains($e, "user_email")) {
        http_response_code(409);
    ?>
        <div mix-update="#toast-container">
            <p>Email already exists</p>
        </div>
<?php
        exit;
    }

    exit;
}
?>