<?php

/** @var array $coaster */

json_encode($coaster);
?>
<aside id="map" class="flex-1 bg-gray-400 min-h-50 md:min-h-36">
</aside>


<script>
    // initialize the map on the "map" div with a given center and zoom
    const map = L.map('map').setView([<?= json_encode($coaster["coaster_lon"]) ?>, <?= json_encode($coaster["coaster_lat"]) ?>], 12);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap &copy; CARTO',
    }).addTo(map);


    const marker = L.marker([<?= json_encode($coaster["coaster_lon"]) ?>, <?= json_encode($coaster["coaster_lat"]) ?>], {
        icon: L.divIcon({
            className: 'map-marker',
            html: `<button></button>`,
        }),
    });
    marker.bindPopup(`<p class="small"><?= _($coaster["coaster_title"]) ?></p>`);
    marker.addTo(map);
</script>