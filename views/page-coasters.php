<?php
$title = "Coasters";
$active = "coasters";

require_once ROOT . "/views/components/_header.php";

require_once ROOT . "/config/db.php";
require_once ROOT . "/apis/api-get-coasters.php";

// dynamic pagination, get all rows
$offset = 0;
$total_coasters = $_db->query("SELECT COUNT(*) FROM coasters")->fetchColumn();

// Get selected coaster, if any. Im fetching either way, because I want $park to return empty if it isnt used, for making the page dynamic
$param = $_GET["coaster"] ?? null;
$stmt = $_db->prepare("SELECT * FROM coasters WHERE coaster_pk = ?");
$stmt->execute([$param]);
$coaster = $stmt->fetch();


if (!$coaster) {
    echo "<h1>Browse coasters</h1>";
?>
    <section class="w-fit grid">
        <form action="" class="place-self-end">

            <select name="filter_coaster" id="">
                <option value="filter_az">A - Z</option>
            </select>

        </form>
    </section>

    <section class="border-t-2 border-(--darkened-eggshell) my-10 py-5 flex flex-col md:grid md:grid-cols-3 gap-8">
        <aside class="flex flex-col gap-6 md:col-start-1">
            <?php require ROOT . "/views/components/__search-park.php"; ?>
        </aside>

        <section id="coasters_container" class="col-start-2 col-span-2">
            <div id="parks_search_results" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 slide-in">
                <?php
                foreach ($coasters as $coaster) {
                    require ROOT . '/views/components/__coaster-card.php';
                }
                ?>
            </div>
            <div id="pagination_count">
                <p class="my-4 small">Showing <?php _(count($coasters)) ?> of <?php _($total_coasters) ?> coasters</p>

            </div>
        </section>
        <div id="pagination" class="col-start-2 col-span-2 flex gap-4 justify-center my-6">
            <form mix-get="/apis/components/api-pagination-coasters.php?offset=<?php _(max(0, $offset - 6)) ?>"><button class="btn-secondary">Prev.</button></form>
            <form mix-get="/apis/components/api-pagination-coasters.php?offset=<?php _($offset + 6) ?>"><button class="btn-secondary">Next</button></form>
        </div>

    </section>
<?php
    exit;
}
?>

<h1><?php _($coaster["coaster_title"]) ?></h1>

<section class="my-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8 md:h-78 lg:h-128">
    <p class=""><?php _($coaster["coaster_description"]) ?></p>
    <img class="rounded-md w-full h-48 md:h-full object-cover row-1 md:col-2 lg:col-span-2 lg:col-start-2" src="<?php if ($coaster['coaster_image_path'] !== ""): ?><?php _($coaster["coaster_image_path"]) ?> <?php else: ?><?php _("static/assets/images/coaster-placeholder.webp") ?> <?php endif; ?>" alt="Coaster" srcset="">
</section>

<?= $coaster["coaster_title"]; ?>
<?= $total_coasters; ?>