<?php
try {
    require_once ROOT . "/config/_.php";
    require_once ROOT . "/config/db.php";

    $coaster_pk = $_GET["coaster"] ?? "";
    $review_body = _validate_review_body();
    $review_rating = (int)($_POST["review_rating"] ?? 5);

    // Get userdata
    $stmt = $_db->prepare("SELECT user_pk FROM users WHERE user_email = :email");
    $stmt->execute([":email" => $_SESSION["user_email"] ?? ""]);
    $user = $stmt->fetch();
    if (!$user) {
        throw new Exception("You must be logged in to post a review", 401);
    }

    $stmt = $_db->prepare("INSERT INTO reviews (review_pk, review_user_fk, review_coaster_fk, review_body, review_rating, review_created_at, review_deleted_at) 
    VALUES (:review_pk, :review_user_fk, :review_coaster_fk, :review_body, :review_rating, :review_created_at, 0)");
    $stmt->execute([
        ":review_pk" => uuidv4_nodash(),
        ":review_user_fk" => $user["user_pk"],
        ":review_coaster_fk" => $coaster_pk,
        ":review_body" => $review_body,
        ":review_rating" => $review_rating,
        ":review_created_at" => time(),
    ]);
    // If everyting goes smooth, redirect to coaster page
    $message = "Review created";
?>
    <browser mix-redirect="/coasters?coaster=<?php _($coaster_pk) ?>"></browser>
    <browser mix-update="#toast-container-header">
        <?php require_once ROOT . "/views/components/__toast_success.php" ?>
    </browser>
<?php
} catch (Exception $e) {
    http_response_code($e->getCode());
    $message = $e->getMessage();
    // Display error toast with message
?>
    <browser mix-update="#toast-container-header">
        <?php require_once ROOT . "/views/components/__toast_error.php" ?>
    </browser>
<?php
}
