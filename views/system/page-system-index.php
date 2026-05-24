<?php
require_once ROOT . "/config/db.php";
$stmt = $_db->prepare("SELECT user_authority FROM users WHERE user_pk = :user_pk");
$stmt->execute([":user_pk" => $_SESSION["user_pk"]]);
$user_autority = $stmt->fetchColumn();

if ($user_autority <= 0) {
    header("Location: /404");
    exit;
}


require_once ROOT . "/views/components/system/_system-header.php";
$card_copys = json_decode(file_get_contents(ROOT . "/static/assets/copy/system-card-copy.json"), true);


?>

<section class="my-18">
    <div class="flex gap-8 flex-wrap">
        <?php foreach ($card_copys as $card) {
            require ROOT . "/views/components/system/_system-dashboard-card.php";
        } ?>

    </div>
</section>


<?php
// require_once ROOT . "/views/components/system/_system-footer.php";
require_once ROOT . "/views/components/_footer.php";
