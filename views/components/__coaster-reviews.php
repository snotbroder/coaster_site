<?php

/** @var array $coaster */
/** @var string $park_title */

// Get user data from db, based on session stored email
$stmt = $_db->prepare("SELECT user_pk FROM users WHERE user_email = :email");
$stmt->execute([":email" => $_SESSION["user_email"] ?? ""]);
$user = $stmt->fetch();



$coaster_pk = $_GET["coaster"] ?? "";

$stmt = $_db->prepare("SELECT * FROM reviews WHERE review_coaster_fk = :review_coaster_fk AND review_deleted_at = 0 ORDER BY review_created_at DESC");
$stmt->execute([":review_coaster_fk" => $_GET["coaster"] ?? ""]);
$reviews = $stmt->fetchAll();

//Get total of rows in relevant reviews
$total_reviews = $_db->query("SELECT COUNT(*) FROM reviews WHERE review_coaster_fk = " . $_db->quote($coaster_pk) . "AND review_deleted_at = 0")->fetchColumn();




?>
<div id="toast_container" class="fixed top-0 left-0"></div>
<section class="my-12 md:my-0">

    <div class="flex justify-between border-b border-b-(--darkened-eggshell) mb-4 md:pb-4 lg:pb-5.5">
        <h4>User reviews <span class="text-(--light-indigo)">(<?php _($total_reviews) ?>)</span></h4>

        <?php
        if (!$user) {
        ?>
            <a class="hyperlink mb-2" href="/login">Login or sign up to write a review</a>
        <?php
        } else {
        ?>
            <button command="show-modal" commandfor="review-dialog" class="btn-primary">Write a review!</button>
        <?php
        }
        ?>

    </div>

    <section class="flex flex-col gap-2">
        <?php if ($total_reviews == 0): ?>
            <p class="text-(--light-indigo)!">It's so empty in here...</p>
        <?php endif; ?>
        <?php foreach ($reviews as $review) {
            require ROOT . "/views/components/__review-card.php";
        } ?>
    </section>

</section>

<dialog id="review-dialog" class="anim-slide-up">
    <div class="absolute top-7 right-7 rounded-full cursor-pointer hover:bg-(--darkened-eggshell) py-0.75 px-2">
        <button class="cursor-pointer" commandfor="review-dialog" command="close">&#x2715;</button>
    </div>
    <h4>Reviewing <?php _($coaster["coaster_title"]) ?> at <?php _($park_title) ?></h4>
    <div class="fixed top-12 right-2 z-100" id="toast-container"></div>
    <div class="mt-6 mb-4">
        <p class="xsmall mb-2">Logged in as</p>
        <div class="w-full flex gap-3 items-center">
            <img class="w-6 object-fit rounded-full" src="/static/assets/avatars/<?php _($_SESSION["user_avatar_path"] ?? "/static/assets/avatars/profile_avatar_default.jpg") ?>" alt="Profile image">
            <p class="small text-(--light-indigo)!"><?php _($_SESSION["user_username"]); ?> (<?php _($_SESSION["user_email"]); ?>)</p>
        </div>
    </div>
    <form mix-post="/api-create-review?coaster=<?php _($coaster["coaster_pk"]) ?>" class="default review-container my-8">
        <p>Review <span class="text-sm text-(--light-indigo)">(<?php _(review_body_min . "-" . review_body_max . " chars.")  ?>)</span></p>
        <div class="">
            <select name="review_rating" id="">
                <option value="5">&#x2605;&#x2605;&#x2605;&#x2605;&#x2605; (5)</option>
                <option value="4">&#x2605;&#x2605;&#x2605;&#x2605;&#x2606; (4)</option>
                <option value="3">&#x2605;&#x2605;&#x2605;&#x2606;&#x2606; (3)</option>
                <option value="2">&#x2605;&#x2605;&#x2606;&#x2606;&#x2606; (2)</option>
                <option value="1">&#x2605;&#x2606;&#x2606;&#x2606;&#x2606; (1)</option>

            </select>
        </div>
        <textarea class="review-body" name="review_body" id="" placeholder="Write a review"></textarea>


        <span class="flex flex-col md:flex-row gap-4">
            <button class="btn-primary">Post review</button>
            <button type="button" class="btn-secondary" commandfor="review-dialog" command="close">Cancel</button>
        </span>
    </form>
</dialog>