<?php
$title = "Map";
$active = "map";

require_once ROOT . '/views/components/_header.php';
require_once ROOT . "/config/db.php";

$sql = "SELECT * FROM parks";
$stmt = $_db->prepare($sql);
$stmt->execute();
$parks = $stmt->fetchAll();

?>


<h1>Map</h1>
<?php echo uuidv4_nodash() ?>
<section id="map_container">
    <!-- <form action="">
        <div>
            <input type="text" placeholder="search...">
        </div>
    </form> -->
    <section class="flex flex-col gap-2 md:grid grid-cols-5">
        <section id="map" class="col-1 md:col-span-3"></section>
        <aside id="map_aside" class="flex flex-wrap gap-4 p-2 sm:col-span-2">
            <p class="small text-(--light-indigo)! p-2">Click a marker to see coasters</p>
        </aside>
    </section>
</section>
<script>
    // initialize the map on the "map" div with a given center and zoom
    const map = L.map('map').setView([49, 12], 4.5);

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

    // Encode data from php database fetch
    const parks = <?= json_encode($parks) ?>;
    console.log(parks)

    parks.forEach(park => {
        var marker = L.marker([park.park_lon, park.park_lat], {
            icon: L.divIcon({
                className: 'map-marker',
                html: `<button
                onclick="mixhtml(); return false;"
                mix-post="/api-get-park-coasters?park_pk=${park.park_pk}">
                </button>`,
            }),
            park_pk: park.park_pk
        }).addTo(map);

        marker.bindPopup(`<a href="/parks?park=${park.park_slug}" class="hyperlink-mini">${park.park_title}</a>`);
        markers.addLayer(marker);
    })
</script>
<?php require_once ROOT . '/views/components/_footer.php'; ?>