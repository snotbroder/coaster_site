<?php

/** @var array $park_review */
$park = $park_review;
$coaster["coaster_park_fk"] = $park["park_pk"];

$stmt = $_db->prepare("
SELECT reviews.*, coasters.coaster_title
FROM reviews
JOIN coasters ON reviews.review_coaster_fk = coasters.coaster_pk
WHERE reviews.review_user_fk = :user_pk
AND coasters.coaster_park_fk = :park_pk
ORDER BY reviews.review_created_at DESC
");
$stmt->execute([":user_pk" => $_SESSION["user_pk"], ":park_pk" => $park["park_pk"]]);
$reviews = $stmt->fetchAll();


$latest_review = max(array_column($reviews, "review_created_at"));
$reviews_count = count($reviews);


?>

<details class="group bg-(--light-eggshell) rounded-lg border-2 border-(--darkened-eggshell) hover:border-(--light-indigo) cursor-pointer">
    <summary class="bg-(--pure-eggshell) border-b border-(--darkened-eggshell) flex flex-col sm:flex-row justify-between gap-4 md:items-center rounded-lg p-4 lg:px-8 group-open:rounded-b-none anim-slide-up">
        <div class="flex gap-4 flex-wrap">
            <div class="w-11 h-11 my-auto">
                <?php require ROOT . "/views/components/___flag.php"; ?>
            </div>
            <div class="flex flex-col gap-1 flex-wrap">
                <h5><?php _($park_review["park_title"]) ?></h5>
                <span class="flex flex-col md:flex-row gap-1 md:gap-4 md:items-center">
                    <p class="xsmall"><?php _($park_review["park_city"]) ?>, <?php _($park_review["park_country"]) ?></p>
                    <p class="hidden md:inline pt-1.5 text-(--darkened-indigo)">&#10625;</p>
                    <p class="xsmall">Latest review from <?php timeago($latest_review) ?></p>

                </span>
            </div>
        </div>
        <div class="flex flex-col gap-0 text-right">
            <h5 class="font-black!"><?php _($reviews_count) ?></h5>
            <p class="small text-(--light-indigo)!">reviews</p>
        </div>
    </summary>
    <ul class="flex flex-col">
        <?php foreach ($reviews as $review) {
        ?>
            <article class="border-b border-(--darkened-eggshell)">
                <?php
                require ROOT . "/views/components/___myreviews-review-card.php";
                ?>
            </article>
        <?php
        } ?>

    </ul>
</details>