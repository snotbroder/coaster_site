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

$sql_countries = "SELECT DISTINCT park_country_code FROM parks ORDER BY park_country_code ASC";
$stmt = $_db->prepare($sql_countries);
$stmt->execute();
$countries = $stmt->fetchAll();

$sql = "SELECT * FROM coasters WHERE coaster_is_operational != 0";
$stmt = $_db->prepare($sql);
$stmt->execute();
$coasters = $stmt->fetchAll();

?>


<h1>Map</h1>


<section id="map_container">
    <div class="border-b border-b-(--darkened-eggshell) mb-4 pb-6">
        <form class="form-switch">
            <h2>Type</h2>
            <div class="switch-field">
                <input type="radio" id="radio-one" name="switch-one" value="yes" checked />
                <label for="radio-one">Yes</label>
                <input type="radio" id="radio-two" name="switch-one" value="no" />
                <label for="radio-two">No</label>
            </div>
    </div>
    <section class="flex flex-col gap-2 md:grid grid-cols-5">
        <section id="map" class="col-1 md:col-span-3"></section>
        <aside id="map_aside" class="mix-hidden flex flex-wrap gap-4 p-2 sm:col-span-2">
            <p class="small text-(--light-indigo)! p-2">Click a marker to see coasters</p>
        </aside>
    </section>
</section>
<!-- Filter section -->
<section id="map_filter" class="mb-4 py-2 border-b border-b-(--darkened-eggshell) ">
    <h4 class="mb-2">Filter</h4>
    <form action="" class="w-fit flex flex-row! gap-10!">
        <div>
            <label for="filter_country_code">Country</label>
            <select name="filter_country_code" id="">
                <option value="all">All</option>
                <?php foreach ($countries as $country):  ?>
                    <option value="<?php _($country["park_country_code"]) ?>">
                        <?php _($country["park_country_code"]) ?>
                    </option>
                <?php endforeach;  ?>
            </select>
        </div>
        <div class="flex place-items-start">
            <label for="filter_is_operational">Is operational</label>
            <input type="checkbox" checked name="filter_is_operational" id="">
        </div>
        <div>
            <label for="filter_min_coasters">Coaster amount</label>
            <select name="filter_min_coasters">
                <option value="all">All</option>
                <option value="1">1+</option>
                <option value="3">3+</option>
                <option value="5">5+</option>
                <option value="10">10+</option>
            </select>
        </div>
        <button class="btn-secondary">filter</button>
    </form>

</section>
<script>
    // initialize the map on the "map" div with a given center and zoom
    const map = L.map('map').setView([52, 9], 4.5);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap &copy; CARTO',
    }).addTo(map);

    var markers = L.markerClusterGroup({
        disableClusteringAtZoom: 15, // <- key option
        spiderfyOnMaxZoom: true,
        // showCoverageOnHover: false,
        maxClusterRadius: 100 // default is 100 pixels
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

    // function addParkMarker(park) {
    //     const marker = L.marker([park.park_lon, park.park_lat], {
    //         icon: L.divIcon({
    //             className: 'map-marker map-marker-park',
    //             html: `<button onclick="mixhtml(); return false;" mix-post="/api-get-park-coasters?park_pk=${park.park_pk}"></button>`,
    //         }),
    //     });
    //     marker.bindPopup(`<a href="/parks?park=${park.park_slug}" class="hyperlink-mini">${park.park_title}</a>`);
    //     marker.on("click", () => map.setView([park.park_lon, park.park_lat], 8));
    //     markers.addLayer(marker);
    // }

    function addCoasterMarker(coaster) {
        const marker = L.marker([coaster.coaster_lon, coaster.coaster_lat], {
            icon: L.divIcon({
                className: 'map-marker map-marker-coaster',
                html: `<button onclick="mixhtml(); return false;" mix-get="/coasters?coaster=${coaster.coaster_pk}"></button>`,
            }),
        });
        marker.bindPopup(`<a href="/coasters?coaster=${coaster.coaster_pk}" class="hyperlink-mini">${coaster.coaster_title}</a>`);
        marker.on("click", () => map.setView([coaster.coaster_lon, coaster.coaster_lat], 16));
        markers.addLayer(marker);
    }

    const parks = <?= json_encode($parks) ?>;
    const coasters = <?= json_encode($coasters) ?>;
    // parks.forEach(addParkMarker);
    coasters.forEach(addCoasterMarker);

    markers.addTo(map);

    // Got help from claude
    document.querySelector("#map_filter form").addEventListener("submit", async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        history.replaceState(null, "", "?" + new URLSearchParams(formData).toString());
        const res = await fetch("/api-filter-parks", {
            method: "POST",
            body: formData
        });
        const filtered = await res.json();
        markers.clearLayers();
        filtered.forEach(addMarker);
        mix_convert();
    });
</script>
<?php require_once ROOT . '/views/components/_footer.php'; ?>