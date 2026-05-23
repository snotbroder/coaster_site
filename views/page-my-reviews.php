<?php

$title = "My reviews";
$active = "my-reviews";

require_once ROOT . '/views/components/_header.php';
if (!$_SESSION) {
    header("Location: /");
    exit;
}
require_once ROOT . "/config/db.php";

//get distinct parks this user has reviewed
$stmt = $_db->prepare("SELECT DISTINCT parks.* FROM parks
    JOIN coasters ON coasters.coaster_park_fk = parks.park_pk
    JOIN reviews ON reviews.review_coaster_fk = coasters.coaster_pk WHERE reviews.review_user_fk = :user_pk
");
$stmt->execute([":user_pk" => $_SESSION["user_pk"] ?? ""]);
$parks_reviewed = $stmt->fetchAll();


?>

<h1>My reviews</h1>
<p>Organised by parks you've been to.</p>

<span></span>

<section class="flex flex-col gap-4">

    <?php foreach ($parks_reviewed as $park_review) {
        require ROOT . "/views/components/__myreviews-park-card.php";
    } ?>


</section>

<?php require_once ROOT . "/views/components/_footer.php"; ?>