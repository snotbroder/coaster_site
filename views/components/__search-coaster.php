<?php
require_once ROOT . "/config/db.php";
require_once ROOT . "/config/_.php";

?>
<section class="bg-(--pure-eggshell) p-8 flex flex-col gap-4">
    <h4>Search coasters</h4>
    <form id="searchForm" mix-post="/api-search-coaster" class="default">
        <div>
            <input id="searchInput" name="search" type="text" placeholder="search...">
        </div>
    </form>

    <section class="w-fit grid">
        <form action="" class="place-self-end">

            <select name="filter_coaster" id="">
                <option value="filter_az">A - Z</option>
            </select>

        </form>
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