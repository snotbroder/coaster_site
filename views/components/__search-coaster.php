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

            <select name="sort" id="">
                <option value="sort">A - Z</option>
            </select>

        </form>
    </section>
    <section>

        <details>
            <summary>
                <h5>Filters</h5>
            </summary>
            <form mix-get="/api-filter-coasters">
                <div>
                    <label for="filter_country">Country</label>
                    <select name="filter_country" id="filter_country">
                        <option value="all">All</option>
                        <option value="Germany">Germany</option>
                        <option value="Sweden">Sweden</option>

                    </select>
                </div>
                <div>
                    <label for="filter_speed">Speed</label>
                    <select name="filter_speed" id="">
                        <option value="all">All</option>
                    </select>
                </div>
                <button>submit</button>
            </form>
        </details>
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
        }, 200);
    })
</script>