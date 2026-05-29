<?php

/** @var array $review 
 */
//get like count for review
$stmt = $_db->prepare("SELECT COUNT(*) FROM likes WHERE like_review_fk = :review_pk");
$stmt->execute([":review_pk" => $review["review_pk"]]);
$review_likes = $stmt->fetchColumn();

if ($review_likes === 0) {
    $review_likes = "0";
}

?>

<form class="flex gap-2 items-center" mix-post="/api-like-review?review_pk=<?php _($review["review_pk"]) ?>">
    <button class="btn-like">
        <span><?php _($review_likes) ?></span> found this helpful
    </button>
</form>