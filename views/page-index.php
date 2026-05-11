<?php
$title = "Home";
$active = "index";
require_once __DIR__ . '/components/_header.php';
?>

<h1>Welcome to the Coaster Codex!</h1>
<p>Rate and review coasters, explore and find information about parks around the globe!</p>

<?php require_once __DIR__ . "/components/__index-search.php"; ?>

<section>
    <h3>Coaster highlight</h3>
</section>
<section>
    <h3>Latest reviews</h3>
</section>
<?php
require_once __DIR__ . '/components/_footer.php';
