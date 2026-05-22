<?php
$title = "Home";
$active = "index";
require_once ROOT . '/views/components/_header.php';
?>
<section class="mb-8">
    <h1>Welcome to the Coaster Codex!</h1>
    <p>Rate and review coasters, explore and find information about parks around the globe!</p>

</section>


<?php require_once ROOT . "/views/components/_index-search.php"; ?>

<?php require_once ROOT . "/views/components/_coaster-highlight.php"; ?>

<section>
    <h3 class="line-through text-(--light-indigo)!">Latest reviews</h3>
</section>
<?php
require_once ROOT . '/views/components/_footer.php';
