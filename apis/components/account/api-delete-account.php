<?php
echo "ok";
require_once ROOT . "/config/db.php";
require_once ROOT . "/config/_.php";


// Just in case
if (!isset($_SESSION["user_pk"])) {
    $message = "No user loggen in";
?>
    <browser mix-update="#toast-container-header">
        <?php require_once ROOT . "/views/components/__toast_error.php" ?>
    </browser>
<?php
    exit;
}

$stmt = $_db->prepare("UPDATE users SET user_deleted_at = :time WHERE user_pk = :user_pk");
$stmt->execute([
    ":time" => time(),
    ":user_pk" => $_SESSION["user_pk"]
]);

// Logout, clearing and destroy session is in here 
require_once ROOT . "/apis/api-logout.php";
