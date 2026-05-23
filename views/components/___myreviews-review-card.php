<?php

/** @var array $review */


// Source - https://stackoverflow.com/a/1241263
$string = $review["review_body"];
$truncated = (strlen($string) > 50) ? substr($string, 0, 50) . '...' : $string;

?>

<li class="p-4 lg:px-8 lg:py-8  hover:bg-(--pure-eggshell) transition-bg duration-75">
    <a href="/coasters?coaster=<?php _($review["review_coaster_fk"]) ?>">
        <div class="flex flex-col md:flex-row justify-between gap-4">
            <div class="flex flex-col gap-1">
                <h4><?php _($review["coaster_title"]) ?></h4>
                <p class="small text-(--light-indigo)!">"<?php _($truncated) ?>"
                </p>
            </div>
            <div class="flex gap-6 items-center flex-wrap">
                <span class="text-(--light-indigo) flex items-center md:items-end md:flex-col gap-1">
                    <p class="small text-right"><?php _($review["review_rating"]) ?> / 5</p>
                    <span>
                        <?php $rating = $review["review_rating"]; require ROOT . "/views/components/___rating-stars.php" ?>
                    </span>
                </span>
                <p class="xsmall text-(--light-indigo)!"><?php timeago($review["review_created_at"]) ?></p>
            </div>
        </div>
    </a>
</li>