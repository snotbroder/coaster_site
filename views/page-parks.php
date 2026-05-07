<?php
$title = "Parks";
$active = "parks";

require_once __DIR__ . '/components/_header.php';
require_once ROOT . '/apis/api-get-parks.php';

$slug = $_GET['park'] ?? null;

// if (!$slug) {
//     header('Location: /');
//     exit;
// }

$stmt = $_db->prepare("SELECT * FROM parks WHERE park_slug = ?");
$stmt->execute([$slug]);
$park = $stmt->fetch();


// Display all parks, default view when no park is selected
if (!$park) {
    echo "<h1>All parks</h1>";
    echo uuidv4_nodash();

?>
    <section class="border-t-2 border-(--darkened-eggshell) my-10 py-5 grid md:grid-cols-3 gap-8">
        <aside class="flex flex-col gap-6 ">
            search
        </aside>
        <section id="parks_container" class="col-span-2">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4 slide-in">
                <?php
                foreach ($parks as $park) {
                    require ROOT . '/views/components/__park-card.php';
                }
                ?></div>
        </section>
    </section>
    <div>
        <form mix-get="/apis/api-getnext-parks.php?offset=6" method="GET"><button>Next</button></form>
    </div>
<?php

    exit;
}

// render selected park coasters 
$stmt = $_db->prepare("SELECT * FROM coasters WHERE park_fk = ?");
$stmt->execute([$park["park_pk"]]);
$coasters = $stmt->fetchAll();
?>

<h1 class=""><?= _($park['park_title']) ?> </h1>
<section class="border-t-2 border-(--darkened-eggshell) my-10 py-5 grid md:grid-cols-3 gap-8">
    <aside class="flex flex-col gap-6 ">
        <img class="rounded-sm" src="<?= _($park['park_image_path']) ?>" alt="Park">
        <div class="flex flex-col gap-4">
            <?php if ($park["park_is_operational"] == '1'): ?>
                <div class="bg-(--system-success)/60 border-2 border-(--system-success) w-fit px-4 rounded-2xl">
                    <p class="small">In operation</p>
                </div>
            <?php else: ?>
                <div class="bg-(--system-failure)/60 border-2 border-(--system-failure) w-fit px-4 rounded-2xl">
                    <p class="small">Not in operation</p>
                </div>
            <?php endif; ?>
            <p><?php _($park["park_city"]) ?>, <?php _($park['park_country']) ?></p>

            <a href="<?= _($park['park_website']) ?>" target="_blank">Visit website</a>
            <p class="small text-(--pure-eggshell)! "><?= _($park['park_pk']) ?></p>
        </div>
    </aside>
    <section class="col-span-2">
        <h3 class="mb-4">Coaster at <?php _($park['park_title']) ?></h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 slide-in">
            <?php
            if ($coasters == []) {
                _("No coasters found for this park");
                exit;
            }
            foreach ($coasters as $coaster) {
                require ROOT . '/views/components/__coaster-card.php';
            }
            ?></div>
    </section>
</section>
<?php
require_once ROOT . '/views/components/_footer.php';
