<?php
$title = "Home";
$active = "index";
require_once __DIR__ . '/components/_header.php';
?>

<h1>Welcome to the Coaster Codex!</h1>
<p>Rate and review coasters, explore and find information about parks around the globe!</p>

<?php if ($_SESSION["user_email"] ?? false) : ?>
    <div class="w-2">
        <img class="object-fit rounded-full" src="<?php _($_SESSION["user_avatar_path"] ?? "/static/assets/avatars/profile_avatar_default.jpg") ?>" alt="Profile image">
    </div>

    <p class="small text-(--light-indigo)!">Hello <?php _($_SESSION["user_email"]) ?></p>
<?php endif; ?>
<?php require_once __DIR__ . "/components/_index-search.php"; ?>

<section>
    <h3>Coaster highlight</h3>
</section>
<section>
    <h3>Latest reviews</h3>
</section>
<?php
require_once __DIR__ . '/components/_footer.php';
