<?php

/** @var array $coaster */

json_encode($coaster);
?>
<aside id="map" class="flex-1 bg-gray-400 min-h-36">

</aside>

<?php _($coaster["coaster_lon"]) ?>
<?php _($coaster["coaster_lat"]) ?>


<script>
    // initialize the map on the "map" div with a given center and zoom
    const map = L.map('map').setView([52, 9], 4.5);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap &copy; CARTO',
    }).addTo(map);


    function addMarker() {
        const marker = L.marker([<?php json_encode($coaster["coaster_lon"]) ?>, <?php json_encode($coaster["coaster_lat"]) ?>], {
            icon: L.divIcon({
                className: 'map-marker',
                html: `<button onclick="mixhtml(); return false;" mix-post="/api-get-park-coasters?park_pk=${park.park_pk}"></button>`,
            }),
        });
        marker.bindPopup(`<a href="/parks?park=" class="hyperlink-mini"><?php _($coaster["coaster_title"]) ?></a>`);
        markers.addLayer(marker);
    }

    markers.addTo(map);
</script>