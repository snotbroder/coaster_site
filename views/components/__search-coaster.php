<?php
require_once ROOT . "/config/db.php";
require_once ROOT . "/config/_.php";


// $sql = "SELECT * FROM coasters ORDER BY coaster_title ASC LIMIT 3";
// $stmt = $_db->prepare($sql);
// $stmt->execute();
// $coasters = $stmt->fetchAll();
?>
<section class="bg-(--pure-eggshell) p-8 flex flex-col gap-4">
    <h4>Search coasters</h4>
    <form id="searchForm" mix-post="/api-search-coaster" class="default">
        <div>
            <input id="searchInput" name="search" type="text" placeholder="search...">
        </div>
    </form>
    <section id="parks_search_result" class="grid gap-2 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">



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