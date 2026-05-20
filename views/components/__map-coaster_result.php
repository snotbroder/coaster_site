<?php

/** @var array $coasters */
/** @var array $park_info */

$sql = "SELECT COUNT(*) FROM coasters WHERE coaster_park_fk = :park_pk";
$stmt = $_db->prepare($sql);
$stmt->execute([":park_pk" =>  $park_info["park_pk"]]);
$entries_count = $stmt->fetchColumn();
?>
<div class="border-b border-b-(--darkened-eggshell) flex flex-col gap-4 py-2 pb-8 mb-6">
    <div class="flex flex-col justify-between gap-4 lg:gap-2 md:mb-4 pb-6">
        <h3><?php _($park_info["park_title"]) ?></h3>
        <span class="flex gap-1">
            <div class="w-4">
                <img src="static/assets/icons/location.svg" alt="location icon">
            </div>
            <p class="xsmall text-(--light-indigo)! w-full flex flex-row"><?php _($park_info["park_city"]) ?>, <?php _($park_info["park_country"]) ?> | EST. <?php _($park_info["park_year"]) ?></p>

            <p class="xsmall"></p>
        </span>
        <?php if ($park_info["park_is_operational"] == "1"): ?>
            <div class="bg-(--system-success)/60 border-2 border-(--system-success) w-fit px-4 rounded-2xl">
                <p class="small">In operation</p>
            </div>
        <?php else: ?>
            <div class="bg-(--system-failure)/60 border-2 border-(--system-failure) w-fit px-4 rounded-2xl">
                <p class="small">Not in operation</p>
            </div>
        <?php endif; ?>
    </div>
    <a class="btn-primary text-center!" href="/parks?park=<?php _($park_info["park_slug"]) ?>">See more</a>
</div>
<div class="flex gap-3 place-center">
    <h5 class="font-semibold text-(--light-indigo)">Coasters</h5>
    <div class="w-full h-0.5 my-auto bg-(--darkened-eggshell) rounded-2xl"></div>
    <p class="small text-(--light-indigo)!"><?php _($entries_count) ?></p>
</div>
<?php foreach ($coasters as $coaster): ?>
    <?php require ROOT . "/views/components/__coaster-card.php"; ?>
<?php endforeach; ?>