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
            <?php require ROOT . "/views/components/__search-coaster.php"; ?>
        </aside>

        <section id="coasters_container" class="col-start-2 col-span-2">
            <div id="coasters_search_results" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 slide-in">
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
<h4 class="text-(--light-indigo)! mt-2">At
    <?php
    // Get park_title from park table through park_fk value from coaster table, inline. Had help from claude.
    $park_title = $_db->query("SELECT park_title FROM parks WHERE park_pk = " . $_db->quote($coaster["park_fk"]))->fetchColumn();
    _($park_title); ?>
</h4>

<section class="my-8 mb-9 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8 md:h-78 lg:h-128 md:mb-18 lg:mb-24 overflow-hidden">
    <div class="flex flex-col gap-16 md:gap-4 lg:gap-6 min-h-0">
        <p class="overflow-y-auto"><?php _($coaster["coaster_description"]) ?></p>

        <?php require_once ROOT . "/views/components/__coastermap.php" ?>

    </div>
    <img class="rounded-md w-full h-48 md:h-full object-cover row-1 md:col-2 lg:col-span-2 lg:col-start-2 min-h-0"
        src="<?php _($coaster["coaster_image_path"] ?: "/static/assets/images/coaster-placeholder.webp") ?>"
        onerror="this.onerror=null; this.src='/static/assets/images/coaster-placeholder.webp'"
        alt="Coaster">
</section>
<section class="my-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8 ">
    <div class="row-end-1 md:row-auto md:col-start-2 md:col-span-2">

        <?php require_once ROOT . "/views/components/__coaster-reviews.php" ?>

    </div>
    <div class="md:col-1 md:row-start-1">
        <?php require_once ROOT . "/views/components/__coasterstats-table.php" ?>
    </div>

</section>
<?php require_once ROOT . "/views/components/__coaster-see-also.php" ?>