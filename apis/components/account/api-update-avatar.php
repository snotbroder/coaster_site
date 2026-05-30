<?php

require_once ROOT . "/config/db.php";
require_once ROOT . "/config/_.php";

try {
    if (!isset($_SESSION["user_pk"])) {
        throw new Exception("Not logged in", 401);
    }

    $file = _validate_user_avatar();

    $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $filename = uuidv4_nodash() . "." . $ext;
    $dest = ROOT . "/static/assets/avatars/" . $filename;

    if (!move_uploaded_file($file["tmp_name"], $dest)) {
        throw new Exception("Failed to save file", 500);
    }

    $stmt = $_db->prepare("UPDATE users SET user_avatar_path = :avatar_file WHERE user_pk = :user_pk");
    $stmt->execute([
        ":avatar_file"  => $filename,
        ":user_pk" => $_SESSION["user_pk"],
    ]);

    // Set new session data for avatar path
    $_SESSION["user_avatar_path"] = $filename;
    $message = "Avatar updated successfully";
?>
    <browser mix-update="#toast-container-header">
        <?php require_once ROOT . "/views/components/__toast_success.php" ?>
    </browser>
    <browser mix-update="#avatar_image_container">
        <img class="object-fit rounded-full w-full" src="/static/assets/avatars/<?php _($_SESSION["user_avatar_path"] ?? "profile_avatar_default.jpg") ?>" alt="Profile image">
    </browser>
<?php

} catch (Exception $e) {
    $message = $e->getMessage();
?>
    <browser mix-update="#toast-container-header">
        <?php require_once ROOT . "/views/components/__toast_error.php" ?>
    </browser>

<?php

}
