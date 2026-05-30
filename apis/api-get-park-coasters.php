<?php
require_once ROOT . "/config/db.php";
require_once ROOT . "/config/_.php";

$park_pk = $_GET["park_pk"] ?? null;

$sql = "SELECT * FROM coasters WHERE coaster_park_fk = :pk ORDER BY coaster_is_operational DESC, coaster_title ASC";
$stmt = $_db->prepare($sql);

$stmt->bindValue(':pk', $park_pk);
$stmt->execute();
$coasters = $stmt->fetchAll();

$sql = "SELECT * FROM parks WHERE park_pk = :pk";
$stmt = $_db->prepare($sql);

// $stmt->bindValue(':pk', $park_pk);
$stmt->execute([":pk" => $park_pk]);
$park_info = $stmt->fetch();

?>
<browser mix-update="#aside_content">
    <?php require ROOT . "/views/components/__map-coaster_result.php"; ?>

</browser>