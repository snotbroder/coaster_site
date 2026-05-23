<?php
try {
    require_once ROOT . "/config/_.php";
    require_once ROOT . "/config/db.php";

    $review_pk = $_GET["review_pk"] ?? "";
    if (!$review_pk) throw new Exception("Missing review", 400);

    $review_body = _validate_review_body();

    $stmt = $_db->prepare("UPDATE reviews SET review_body = :body WHERE review_pk = :review_pk");
    $stmt->execute([
        ":body" => $review_body,
        ":review_pk" => $review_pk,
    ]);
    $message = "Review edited successfully";

    // Get fresh data from db, to paste into card
    $stmt = $_db->prepare("SELECT * FROM reviews WHERE review_pk = :review_pk");
    $stmt->execute([":review_pk" => $review_pk]);
    $review = $stmt->fetch();
?>
    <browser mix-update="#review_content_<?php _($review_pk) ?>">
        <div class="flex gap-3 items-center">
            <span class="text-(--light-indigo) flex gap-1 items-center">
                <?php require_once ROOT . "/views/components/___rating-stars.php" ?>
                <p class="small"><?php _($review["review_rating"]) ?> / 5</p>
            </span>
            <p class="xsmall text-(--light-indigo)!"><?php timeago($review["review_created_at"]) ?></p>
        </div>
        <p><?php _($review["review_body"]) ?></p>
    </browser>
    <browser mix-update="#toast-container-header">
        <?php require_once ROOT . "/views/components/__toast_success.php" ?>
    </browser>

<?php
} catch (Exception $e) {
    http_response_code($e->getCode());
    $message = $e->getMessage();
?>
    <browser mix-update="#toast-container-header">
        <?php require_once ROOT . "/views/components/__toast_error.php" ?>
    </browser>
<?php
}
