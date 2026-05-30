<?php
$title = "Map";
$active = "map";

require_once ROOT . '/views/components/_header.php';
require_once ROOT . "/config/db.php";

// Get park data, also get country_code but only once for select element
$sql = "SELECT * FROM parks ORDER BY park_title DESC";
$stmt = $_db->prepare($sql);
$stmt->execute();
$parks = $stmt->fetchAll();

$sql_countries = "SELECT DISTINCT park_country FROM parks ORDER BY park_country ASC";
$stmt = $_db->prepare($sql_countries);
$stmt->execute();
$countries = $stmt->fetchAll();

$sql = "SELECT * FROM coasters WHERE coaster_is_operational != 0";
$stmt = $_db->prepare($sql);
$stmt->execute();
$coasters = $stmt->fetchAll();

?>


<section id="map_container">
    <section class="relative flex flex-col gap-2 overflow-hidden">
        <aside id="map_filters" class="shadow-lg">
            <form id="filterForm" class="form-switch flex gap-2 items-center">
                <div class="switch-field">
                    <input type="radio" id="radio-one" name="switch" value="coasters" checked />
                    <label for="radio-one">Coasters</label>
                    <input type="radio" id="radio-two" name="switch" value="parks" />
                    <label for="radio-two">Parks</label>
                </div>
                <div class="filter-search-wrapper flex gap-1">
                    <input name="filter_search" type="text" placeholder="Search a name">
                </div>
                <div>
                    <!-- <label for="filter_country_code">Country</label> -->
                    <select name="filter_country" class="">
                        <option value="all">Country</option>
                        <?php foreach ($countries as $country):  ?>
                            <option value="<?php _($country["park_country"]) ?>">
                                <?php _($country["park_country"]) ?>
                            </option>
                        <?php endforeach;  ?>
                    </select>
                </div>
            </form>

        </aside>
        <section id="map" class=""></section>
        <aside id="map_aside" class="bg-(--pure-eggshell)/65">
            <button id="aside_close">&#x2715;</button>
            <div id="aside_content"></div>
        </aside>
    </section>
</section>


</section>
<script>
    // initialize the map on the "map" div with a given center and zoom
    const map = L.map('map', {
        gestureHandling: true
    }).setView([52, 9], 4.5);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap &copy; CARTO',
    }).addTo(map);

    var markers = L.markerClusterGroup({
        disableClusteringAtZoom: 15, // <- key option
        spiderfyOnMaxZoom: true,
        maxClusterRadius: 50 // default is 100 pixels
    });

    const mapAside = document.querySelector("#map_aside");
    document.querySelector("#aside_close").addEventListener("click", () => {
        mapAside.classList.remove("visible");
    });

    // Test marker
    // var marker = L.marker([48.26612642549017, 7.72245819844865], {
    //     icon: L.divIcon({
    //         className: 'map-marker',
    //         html: `
    //         <button></button>
    //         `,
    //     }),
    // }).addTo(map);

    function addParkMarker(park) {
        const marker = L.marker([park.park_lon, park.park_lat], {
            icon: L.divIcon({
                className: 'map-marker map-marker-park',
                html: `<button onclick="mixhtml(); return false;" mix-post="/api-get-park-coasters?park_pk=${park.park_pk}"></button>`,
            }),
        });
        marker.bindTooltip(park.park_title);
        marker.on("click", () => {
            map.setView([park.park_lon, park.park_lat], 8);
            mapAside.classList.add("visible");
        });

        markers.addLayer(marker);
    }

    function addCoasterMarker(coaster) {
        const marker = L.marker([coaster.coaster_lon, coaster.coaster_lat], {
            icon: L.divIcon({
                className: 'map-marker map-marker-coaster',
                html: `<button onclick="mixhtml(); return false;" mix-get="/coasters?coaster=${coaster.coaster_pk}"></button>`,
            }),
        });
        marker.bindTooltip(coaster.coaster_title);
        marker.bindPopup(`<a href="/coasters?coaster=${coaster.coaster_pk}" class="hyperlink-mini">${coaster.coaster_title}</a>`);
        marker.on("click", () => map.setView([coaster.coaster_lon, coaster.coaster_lat], 16));
        markers.addLayer(marker);
    }



    // default markers
    const parks = <?= json_encode($parks) ?>;
    const coasters = <?= json_encode($coasters) ?>;

    coasters.forEach(addCoasterMarker);
    markers.addTo(map);

    // Switch coasters/parks
    // const filterForm = document.querySelector("#filterForm");
    // filterForm.addEventListener("change", async (e) => {
    //     let value = e.target.value;
    //     console.log(value)
    //     markers.clearLayers();

    //     if (value == "coasters") {
    //         coasters.forEach(addCoasterMarker);
    //     }
    //     if (value == "parks") {
    //         parks.forEach(addParkMarker);
    //     }
    //     markers.addTo(map);
    //     let markerCount = markers.getLayers().length;
    //     console.log(markerCount)

    // })



    // Got help from claude
    // document.querySelector("#map_filter form").addEventListener("change", async (e) => {
    //     e.preventDefault();
    //     const formData = new FormData(e.target);
    //     history.replaceState(null, "", "?" + new URLSearchParams(formData).toString());
    //     const res = await fetch("/api-filter-parks", {
    //         method: "POST",
    //         body: formData
    //     });
    //     const filtered = await res.json();
    //     markers.clearLayers();
    //     filtered.forEach(addMarker);
    //     mix_convert();
    // });

    filterForm.addEventListener("change", async () => {
        const formData = new FormData(filterForm);
        const params = new URLSearchParams(formData);

        history.replaceState(null, "", "/map?" + params.toString());
        const res = await fetch("/api-map-filter?" + params.toString());
        const results = await res.json();

        markers.clearLayers();

        const mode = formData.get("switch");
        if (mode == "parks") {
            results.forEach(addParkMarker)
        } else {
            results.forEach(addCoasterMarker)
        }
        markers.addTo(map);
    })
</script>
<?php require_once ROOT . '/views/components/_footer.php'; ?>