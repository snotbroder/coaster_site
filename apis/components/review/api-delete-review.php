<?php
try {
    require_once ROOT . "/config/_.php";
    require_once ROOT . "/config/db.php";

    $review_pk = $_GET["review_pk"] ?? "";
    if (!$review_pk) throw new Exception("Missing review", 400);

    $stmt = $_db->prepare("UPDATE reviews SET review_deleted_at = :time WHERE review_pk = :review_pk");
    $stmt->execute([
        ":time" => time(),
        ":review_pk" => $review_pk,
    ]);
    $message = "Review deleted successfully";
?>
    <browser mix-hide="#review_<?php _($review_pk) ?>" mix-fade-1000></browser>
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
