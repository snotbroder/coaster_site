<?php

/** @var array $coaster */

$sql = "SELECT park_country FROM parks WHERE park_pk = :park_pk";
$stmt = $_db->prepare($sql);
$stmt->execute([":park_pk" => $coaster["coaster_park_fk"]]);
$coaster_country = $stmt->fetchColumn();

//Get average rating of coaster
$stmt = $_db->prepare("SELECT AVG(review_rating) FROM reviews WHERE review_coaster_fk = :pk AND review_deleted_at = 0");
$stmt->execute([":pk" => $_GET["coaster"]]);
$reviews_rating_average = $stmt->fetchColumn();
?>


<div>
    <div class="border-b border-b-(--darkened-eggshell) mb-4 pb-6">
        <h4>Coaster stats</h4>
    </div>
    <table class="stats w-full row-1 md:col-1 lg:col-span-1 lg:col-start-1">
        <?php if ($reviews_rating_average != 0): ?>
            <tr>
                <td>User rating</td>
                <td>
                    <?php require ROOT . "/views/components/___rating-stars.php"; ?>
                    (<?php _(round($reviews_rating_average, 2)) ?>)
                </td>
            </tr>
        <?php endif; ?>
        <tr>
            <td>Model</td>
            <td><?php _($coaster["coaster_model"]) ?></td>
        </tr>
        <tr>
            <td>Manufacturer</td>
            <td><?php _($coaster["coaster_manufacturer"]) ?></td>
        </tr>
        <tr>
            <td>Opening year</td>
            <td><?php _($coaster["coaster_year"]) ?></td>
        </tr>
        <tr>
            <td>Country</td>
            <td class="flex gap-2 items-center">
                <?php _($coaster_country) ?>
                <div class="w-3 sm:w-4 lg:w-5 opacity-70 my-auto">
                    <?php require_once ROOT . "/views/components/___flag.php"; ?>
                </div>
            </td>
        </tr>
        <tr>
            <td>Height</td>
            <td><?php _($coaster["coaster_height"]) ?> m</td>
        </tr>
        <tr>
            <td>Length</td>
            <td><?php _($coaster["coaster_length"]) ?> m</td>
        </tr>
        <tr>
            <td>Top speed</td>
            <td><?php _($coaster["coaster_top_speed"]) ?> km/h</td>
        </tr>
        <tr>
            <td>G-force</td>
            <td><?php _($coaster["coaster_gforce"]) ?> g</td>
        </tr>
        <tr>
            <td>Duration</td>
            <td><?php _($coaster["coaster_duration"]) ?> min.</td>
        </tr>
        <?php if ($coaster["coaster_inversion_count"] >= 1): ?>
            <tr>
                <td>Inversions</td>
                <td><?php _($coaster["coaster_inversion_count"]) ?></td>
            </tr>

        <?php endif; ?>

        <tr>
            <td>Status</td>
            <td><?php if ($coaster["coaster_is_operational"] === 1) { ?><span class="text-(--system-success)">In operation</span><?php } else { ?><span class="text-(--system-failure)">Not in operation</span> <?php } ?></td>
        </tr>

    </table>
</div>