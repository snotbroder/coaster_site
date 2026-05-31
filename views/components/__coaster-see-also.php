<?php

/** @var array $coaster */


$sql = "SELECT * FROM coasters WHERE coaster_manufacturer = :coaster_manufacturer AND coaster_pk != :coaster_pk ORDER BY RAND() LIMIT 3";
$stmt = $_db->prepare($sql);
$stmt->execute([
    ":coaster_manufacturer" => $coaster["coaster_manufacturer"],
    ":coaster_pk" => $coaster["coaster_pk"]
]);
$manufacturer = $stmt->fetchAll();

?>
<h4 class="mb-4">More from <?php _($coaster["coaster_manufacturer"]) ?></h4>
<section class="flex flex-col gap-4 sm:grid sm:grid-cols-2 lg:grid-cols-3">
    <?php
    foreach ($manufacturer as $coaster) {
        require ROOT . '/views/components/__coaster-card.php';
    }
    ?>
</section>