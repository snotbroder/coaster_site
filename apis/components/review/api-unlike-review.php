<?php
require_once ROOT . "/config/_.php";
require_once ROOT . "/config/db.php";
$review_pk = $_GET["review_pk"];

// Delete row in db
$stmt = $_db->prepare("DELETE FROM likes WHERE like_user_fk = :user_pk");
$stmt->execute([
    ":user_pk" => $_SESSION["user_pk"]
]);

// Get like data
$stmt = $_db->prepare("SELECT COUNT(*) FROM likes WHERE like_review_fk = :review_pk AND like_user_fk != :user_pk");
$stmt->execute([
    ":review_pk" => $review_pk,
    ":user_pk" => $_SESSION["user_pk"]
]);
$review_likes = $stmt->fetchColumn();


if ($review_likes == 0) {
    $review_likes = "0";
};


?>
<browser mix-update="#review_like_btn_<?php _($review_pk) ?>">
    <form class="flex gap-2 items-center" mix-post="/api-like-review?review_pk=<?php _($review_pk) ?>">
        <button class="btn-like"><span><?php _($review_likes) ?></span> found this helpful</button>
    </form>
</browser>