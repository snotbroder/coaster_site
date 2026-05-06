<?php
$title = "Map";
$active = "map";

require_once __DIR__ . '/components/_header.php';
require_once __DIR__ . '../../apis/api-get-parks.php';
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
                html: `<button></button>`,
            }),
            park_pk: park.park_pk
        }).addTo(map);

        // Event listener for marker click
        marker.bindPopup(`<b>${park.park_title}</b>`);
        marker.on('click', function() {
            console.log('Marker clicked', park.park_title);
        });
        markers.addLayer(marker);
    })
</script>
<?php require_once __DIR__ . '/components/_footer.php'; ?>