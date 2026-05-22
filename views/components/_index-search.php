<?php
require_once ROOT . "/config/db.php";
require_once ROOT . "/config/_.php";
$entries_count = "SELECT COUNT(*) FROM coasters";
$stmt = $_db->prepare($entries_count);
$stmt->execute();
$entries_count = $stmt->fetchColumn();


$sql = "SELECT * FROM coasters ORDER BY coaster_title ASC LIMIT 3";
$stmt = $_db->prepare($sql);
$stmt->execute();
$coasters = $stmt->fetchAll();
?>
<section class="mb-8 bg-(--pure-eggshell) mx-4 p-8 flex flex-col gap-4 rounded-lg shadow-md">
    <h4>Search for a coaster</h4>
    <form id="searchForm" mix-post="/api-index-search-coaster" class="default">
        <div>
            <input id="searchInput" name="search" type="text" placeholder="Search among <?= $entries_count ?> entries, eg. Mælkevejen">
        </div>
    </form>
    <section id="index_search_results" class="grid gap-2 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
        <?php
        if ($coasters == []) {
            _("No coasters found for this park");
            exit;
        }
        foreach ($coasters as $coaster) {
            require ROOT . "/views/components/__coaster-card.php";
        }

        ?>
        <article class="place-self-center"><a class="btn-secondary " href="/coasters">Browse coasters</a></article>
    </section>
</section>
<script>
    const input = document.querySelector("#searchInput");
    const form = document.querySelector("#searchForm");

    let time;
    input.addEventListener("input", (e) => {
        clearTimeout(time);
        time = setTimeout(() => {
            form.dispatchEvent(new Event("submit"));
        }, 300);
    })
</script>