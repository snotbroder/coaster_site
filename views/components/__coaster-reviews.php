<?php

/** @var array $coaster */
/** @var string $park_title */

// Check if user is in session
$stmt = $_db->prepare("SELECT user_pk FROM users WHERE user_email = :email");
$stmt->execute([":email" => $_SESSION["user_email"] ?? ""]);
$user = $stmt->fetch();



$coaster_pk = $_GET["coaster"] ?? "";

$stmt = $_db->prepare("SELECT * FROM reviews WHERE review_coaster_fk = :review_coaster_fk AND review_deleted_at = 0 ORDER BY review_created_at DESC");
$stmt->execute([":review_coaster_fk" => $_GET["coaster"] ?? ""]);
$reviews = $stmt->fetchAll();

?>
<div id="toast_container" class="fixed top-0 left-0"></div>
<section class="my-12 md:my-0">

    <div class="flex justify-between border-b border-b-(--darkened-eggshell) mb-4 pb-4">
        <h4>User reviews</h4>

        <?php
        if (!$user) {
        ?>
            <a class="hyperlink mb-2" href="/login">Login or sign up to write a review</a>
        <?php
        } else {
        ?>
            <button command="show-modal" commandfor="review-dialog" class="btn-primary">Write a reivew!</button>
        <?php
        }
        ?>

    </div>

    <section class="flex flex-col gap-2">
        <?php foreach ($reviews as $review) {
            require ROOT . "/views/components/__review-card.php";
        } ?>
    </section>

</section>

<dialog id="review-dialog" class="anim-slide-up">
    <h4>Reviewing <?php _($coaster["coaster_title"]) ?> at <?php _($park_title) ?></h4>
    <form mix-post="/api-create-review?coaster=<?php _($coaster["coaster_pk"]) ?>" class="review-container flex flex-col">

        <textarea class="review-body" name="review_body" id="" placeholder="Write a review"></textarea>
        <div>
            <select name="review_rating" id="">
                <option value="5">&#x2605;&#x2605;&#x2605;&#x2605;&#x2605; (5)</option>
                <option value="4">&#x2605;&#x2605;&#x2605;&#x2605;&#x2606; (4)</option>
                <option value="3">&#x2605;&#x2605;&#x2605;&#x2606;&#x2606; (3)</option>
                <option value="2">&#x2605;&#x2605;&#x2606;&#x2606;&#x2606; (2)</option>
                <option value="1">&#x2605;&#x2606;&#x2606;&#x2606;&#x2606; (1)</option>

            </select>
        </div>
        <span class="flex flex-col md:flex-row gap-4">
            <button class="btn-primary">Post review</button>
            <button type="button" class="btn-secondary" commandfor="review-dialog" command="close">Cancel</button>
        </span>
    </form>
</dialog>