<?php
$title = "Map";
$active = "map";

require_once __DIR__ . '/components/_header.php';
?>
<h1>Map</h1>
<?php echo uuidv4_nodash() ?>
<section id="map"></section>
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
    var marker = L.marker([55.67960020013266, 12.56464935119663], {
        icon: L.divIcon({
            className: 'map-marker',
            html: `
            <button></button>
            `,
        }),
    }).addTo(map);
</script>
<?php require_once __DIR__ . '/components/_footer.php'; ?>