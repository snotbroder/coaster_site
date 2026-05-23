<?php
$title = "Parks";
$active = "parks";

require_once ROOT . "/views/components/_header.php";
require_once ROOT . "/apis/api-get-parks.php";


// dynamic pagination, get all rows
$offset = 0;
$total_parks = $_db->query("SELECT COUNT(*) FROM parks")->fetchColumn();

// Get selected park, if any. Im fetching either way, because I want $park to return empty if it isnt used, for making the page dynamic
$param = $_GET["park"] ?? null;

$stmt = $_db->prepare("SELECT * FROM parks WHERE park_slug = ?");
$stmt->execute([$param]);
$park = $stmt->fetch();





// Display all parks, default view when no park is selected
if (!$park) {
    echo "<h1>Browse parks</h1>";

?>
    <section class="border-t-2 border-(--darkened-eggshell) my-10 py-5 flex flex-col md:grid md:grid-cols-3 gap-8">
        <aside class="flex flex-col gap-6 md:col-start-1">
            <?php require ROOT . "/views/components/__search-park.php"; ?>
        </aside>

        <section id="parks_container" class="col-start-2 col-span-2">
            <div id="parks_search_results" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 slide-in">
                <?php
                foreach ($parks as $park) {
                    require ROOT . '/views/components/__park-card.php';
                }
                ?>
            </div>
            <div id="pagination_count">
                <p class="my-4 small">Showing <?php _(count($parks)) ?> of <?php _($total_parks) ?> parks</p>

            </div>
        </section>
        <div id="pagination" class="col-start-2 col-span-2 flex gap-4 justify-center my-6">
            <form mix-get="/api-pagination-parks?offset=<?php _(max(0, $offset - 6)) ?>"><button class="btn-secondary">Prev.</button></form>
            <form mix-get="/api-pagination-parks?offset=<?php _($offset + 6) ?>"><button class=" btn-secondary">Next</button></form>
        </div>

    </section>
<?php
    require_once ROOT . '/views/components/_footer.php';
    exit;
}

// render selected park coasters 
$sql = "SELECT * FROM coasters WHERE coaster_park_fk = ? ORDER BY coaster_is_operational DESC";
$stmt = $_db->prepare($sql);
$stmt->execute([$park["park_pk"]]);
$coasters = $stmt->fetchAll();
?>

<section class="border-t-2 border-(--darkened-eggshell) flex flex-col gap-8 my-10 py-5 md:grid md:grid-cols-3 relative top-0">
    <aside class="grid grid-cols-1 sm:grid-cols-2 gap-6 md:flex md:flex-col md:sticky md:top-12 md:self-start anim-slide-up">

        <div class="h-full md:h-48 w-auto relative">
            <img class="w-full h-full object-cover rounded-md" src="<?php _($park["park_image_path"]) ?>" alt="Park entrance">
            <span class="absolute top-2 right-2 rounded-sm py-1.5 px-2 bg-(--pure-eggshell) text-(--light-indigo) text-sm"><?= round($park["park_lon"], 4) ?>&#176; N, <?= round($park["park_lat"], 4) ?>&#176; E</span>
        </div>

        <div class="flex flex-col gap-6">
            <div>
                <h1 class="hyphens-auto wrap-anywhere"><?= _($park["park_title"]) ?></h1>
                <span class="flex gap-1 items-center w-full">
                    <div class="w-4 pb-0.5">
                        <img class="w-fit object-cover rounded-md" src="/static/assets/icons/location.svg" alt="location icon">
                    </div>
                    <p class="small text-(--light-indigo)! my-1!"><?php _($park["park_city"]) ?>, <?php _($park["park_country"]) ?></p>
                </span>
            </div>
            <a href="<?= _($park["park_website"]) ?>" target="_blank" class="btn-primary w-fit">Visit website</a>
            <div class="flex flex-col gap-2 md:gap-4">
                <table class="stats w-full row-1 rounded-md md:col-1 lg:col-span-1 lg:col-start-1">
                    <tr>
                        <td>Status</td>
                        <td>
                            <p class="small">
                                <?php if ($park["park_is_operational"] == "1"): ?>
                            <div class="bg-(--system-success)/60 border-2 border-(--system-success) w-fit px-4 rounded-2xl">
                                In operation
                            </div>
                        <?php else: ?>
                            <div class="bg-(--system-failure)/60 border-2 border-(--system-failure) w-fit px-4 rounded-2xl">
                                Not in operation
                            </div>
                        <?php endif; ?>
                        </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Established</td>
                        <td><?php _($park["park_year"]) ?></td>
                    </tr>
                    <tr>
                        <td>Country</td>
                        <td class="flex gap-2 items-center">
                            <?php _($park["park_country"]) ?>
                            <div class="w-4">
                                <?php $coaster["coaster_park_fk"] = $park["park_pk"];
                                require_once ROOT . "/views/components/___flag.php" ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Coasters</td>
                        <td>0</td>
                    </tr>

                </table>


            </div>
        </div>
    </aside>
    <section class="col-span-2">
        <div class="flex justify-between">
            <h3 class="mb-4">Coasters at <?php _($park["park_title"]) ?></h3>
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
            ?>
        </section>
    </section>
</section>
<?php
require_once ROOT . '/views/components/_footer.php';
