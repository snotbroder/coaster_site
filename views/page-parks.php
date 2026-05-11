<?php
$title = "Parks";
$active = "parks";

require_once __DIR__ . "/components/_header.php";
require_once ROOT . "/apis/api-get-parks.php";

$slug = $_GET["park"] ?? null;
$offset = 0;

// if (!$slug) {
//     header('Location: /');
//     exit;
// }

$stmt = $_db->prepare("SELECT * FROM parks WHERE park_slug = ?");
$stmt->execute([$slug]);
$park = $stmt->fetch();

//Get total of rows in parks
$total_parks = $_db->query("SELECT COUNT(*) FROM parks")->fetchColumn();


// Display all parks, default view when no park is selected
if (!$park) {
    echo "<h1>All parks</h1>";
    echo uuidv4_nodash();

?>
    <section class="border-t-2 border-(--darkened-eggshell) my-10 py-5 flex flex-col md:grid md:grid-cols-3 gap-8">
        <aside class="flex flex-col gap-6 md:col-start-1">
            <?php require ROOT . "/views/components/__search-park.php"; ?>
        </aside>

        <section id="parks_container" class="col-start-2 col-span-2">
            <div id="parks_search_results" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4 slide-in">
                <?php
                foreach ($parks as $park) {
                    require ROOT . '/views/components/__park-card.php';
                }
                ?>
                <p>Showing <?php _(count($parks)) ?> of <?php _($total_parks) ?> parks</p>
            </div>

        </section>
        <div class="col-start-2 col-span-2 flex gap-4 justify-center my-6">
            <form mix-get="/apis/api-getprev-parks.php?offset=<?php _(max(0, $offset - 6)) ?>" method="GET"><button class="btn-secondary">Prev.</button></form>
            <form mix-get="/apis/api-getnext-parks.php?offset=<?php _($offset + 6) ?>" method="GET"><button class="btn-secondary">Next</button></form>
        </div>

    </section>
<?php

    exit;
}

// render selected park coasters 
$sql = "SELECT * FROM coasters WHERE park_fk = ? ORDER BY coaster_is_operational DESC";
$stmt = $_db->prepare($sql);
$stmt->execute([$park["park_pk"]]);
$coasters = $stmt->fetchAll();
?>



<section class="border-t-2 border-(--darkened-eggshell) my-10 py-5 md:grid md:grid-cols-3 gap-8 relative top-0">
    <aside class="grid grid-cols-2 gap-6 md:flex md:flex-col md:sticky md:top-20 md:self-start anim-slide-up">
        <div class="h-24">
            <img class="rounded-sm w-full h-full object-cover" src="<?= _($park["park_image_path"]) ?>" alt="Park">
        </div>
        <div class="flex flex-col justify-between gap-2 lg:gap-4">
            <h1 class=""><?= _($park["park_title"]) ?> </h1>
            <?php if ($park["park_is_operational"] == '1'): ?>
                <div class="bg-(--system-success)/60 border-2 border-(--system-success) w-fit px-4 rounded-2xl">
                    <p class="small">In operation</p>
                </div>
            <?php else: ?>
                <div class="bg-(--system-failure)/60 border-2 border-(--system-failure) w-fit px-4 rounded-2xl">
                    <p class="small">Not in operation</p>
                </div>
            <?php endif; ?>
            <p><?php _($park["park_city"]) ?>, <?php _($park["park_country"]) ?></p>

            <a href="<?= _($park["park_website"]) ?>" target="_blank">Visit website</a>
            <a class="btn-secondary" href="/">See park on map</a>
        </div>
    </aside>
    <section class="col-span-2">
        <div class="flex justify-between">
            <h4 class="mb-4">Coaster at <?php _($park["park_title"]) ?></h4>
            <div class="flex gap-2">
                <span>Sort by:</span>
                <form mix-post="/">
                    <select name="" id="">
                        <option value="tea">A-Z</option>
                        <option value="tea">Z-A</option>
                        <option value="tea">Defunct</option>
                    </select>

                </form>
            </div>
        </div>
        <section class="grid grid-cols-1 sm:grid-cols-2 gap-4 anim-slide-in">
            <?php
            if ($coasters == []) {
                _("No coasters found for this park");
                exit;
            }
            foreach ($coasters as $coaster) {
                require ROOT . "/views/components/__coaster-card.php";
            }
            ?></section>
    </section>
</section>
<?php
// require_once ROOT . "/views/components/_footer.php";
