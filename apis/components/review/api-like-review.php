<?php
try {
    require_once ROOT . "/config/_.php";
    require_once ROOT . "/config/db.php";
    $review_pk = $_GET["review_pk"];

    // Get userdata, authentication
    $stmt = $_db->prepare("SELECT user_pk FROM users WHERE user_pk = :user_pk");
    $stmt->execute([":user_pk" => $_SESSION["user_pk"] ?? ""]);
    $user = $stmt->fetch();
    if (!$user) {
        throw new Exception("You must be logged in to find review helpful.");
    }
} catch (Exception $e) {
    http_response_code($e->getCode());
    $message = $e->getMessage();
?>
    <browser mix-update="#toast-container-header">
        <?php require_once ROOT . "/views/components/__toast_error.php" ?>
    </browser>
<?php
    exit;
}

$stmt = $_db->prepare("INSERT INTO likes (like_user_fk, like_review_fk) VALUES (:user_pk, :review_pk)");
$stmt->execute([
    ":user_pk" => $user["user_pk"],
    ":review_pk" => $review_pk
]);

// Get latest like data
$stmt = $_db->prepare("SELECT COUNT(*) FROM likes WHERE like_review_fk = :review_pk AND like_user_fk != :user_pk");
$stmt->execute([
    ":review_pk" => $_GET["review_pk"],
    ":user_pk" => $_SESSION["user_pk"]
]);
$review_likes = $stmt->fetchColumn();


if ($review_likes == 1) {
    $review_likes = "";
};


?>
<browser mix-update="#review_like_btn_<?php _($review_pk) ?>">
    <?php require_once ROOT . "/views/components/___unlike-btn.php"; ?>
</browser>