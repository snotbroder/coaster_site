<?php
require_once ROOT . "/config/db.php";
require_once ROOT . "/config/_.php";

$stmt = $_db->prepare("SELECT * FROM reviews WHERE review_pk = :review_pk");
$stmt->execute([":review_pk" => $_GET["review_pk"] ?? ""]);
$review = $stmt->fetch();
?>
<browser mix-update="#review_content_<?php _($review["review_pk"]) ?>">
    <div class="flex gap-3 items-center">
        <span class="text-(--light-indigo) flex gap-1 items-center">
            <?php $rating = $review["review_rating"]; require_once ROOT . "/views/components/___rating-stars.php" ?>
            <p class="small"><?php _($review["review_rating"]) ?> / 5</p>
        </span>
        <p class="xsmall text-(--light-indigo)!"><?php timeago($review["review_created_at"]) ?></p>
    </div>
    <p><?php _($review["review_body"]) ?></p>
</browser>