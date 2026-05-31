<?php
require_once ROOT . "/config/db.php";
$stmt = $_db->prepare("SELECT user_authority FROM users WHERE user_pk = :user_pk");
$stmt->execute([":user_pk" => $_SESSION["user_pk"]]);
$user_autority = $stmt->fetchColumn();

if ($user_autority <= 0) {
    header("Location: /404");
    exit;
}

$title = "Configure Users";
$active = "configure-users";


require_once ROOT . "/views/components/system/_system-header.php";
require_once ROOT . "/models/UserModel.php";

$query = new UserModel();

$users = $query->fetch($_db);
?>
<h1 class="mt-6">Browse users</h1>
<section class="grid grid-cols-4 gap-8 my-18">
    <?php foreach ($users as $user) {
        require ROOT . "/views/components/system/__user-card.php";
    } ?>

</section>
<?php
require_once ROOT . "/views/components/_footer.php";
