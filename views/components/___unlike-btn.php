<?php

/** @var array $review
 * @var string $review_pk
 */
// Get like data
$stmt = $_db->prepare("SELECT COUNT(*) FROM likes WHERE like_review_fk = :review_pk AND like_user_fk != :user_pk");
$stmt->execute([
    ":review_pk" => $review_pk,
    ":user_pk" => $_SESSION["user_pk"]
]);
$review_likes = $stmt->fetchColumn();

if ($review_likes === 0) {
    $review_likes = "0";
}

?>


<form class="flex gap-2 items-center" mix-post="/api-unlike-review?review_pk=<?php _($review_pk) ?>">
    <button class="btn-like liked"><span>You <?php echo $review_likes > 0 ? "and " . $review_likes . " other" . ($review_likes > 1 ? "s" : "") : "" ?></span> found this helpful</button>
</form>