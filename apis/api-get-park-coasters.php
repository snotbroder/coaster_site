<?php

require_once ROOT . "/config/db.php";
require_once ROOT . "/config/_.php";
$park_pk = $_GET["park_pk"] ?? null;

$sql = "SELECT * FROM coasters WHERE park_fk = :pk ORDER BY coaster_title ASC";
$stmt = $_db->prepare($sql);

$stmt->bindValue(':pk', $park_pk);
$stmt->execute();
$coasters = $stmt->fetchAll();



?>
<browser mix-update="#map_aside">

    <?php if (empty($coasters)): ?>
        <p class="small text-(--light-indigo)! p-2">No coasters at selected park.</p>
    <?php else: ?>

        <?php foreach ($coasters as $coaster): ?>
            <?php require ROOT . "/views/components/__coaster-card.php"; ?>
        <?php endforeach; ?>
        <div class="block h-90"></div>
    <?php endif; ?>
</browser>