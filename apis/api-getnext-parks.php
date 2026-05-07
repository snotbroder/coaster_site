<?php

// Fetch next parks from DB
require_once __DIR__ . "../../config/db.php";
require_once __DIR__ . "../../config/_.php";
$offset = (int)($_GET['offset'] ?? 6);
$sql = "SELECT * FROM parks ORDER BY park_title ASC LIMIT 6 OFFSET $offset";
$stmt = $_db->prepare($sql);
$stmt->execute();
$parks = $stmt->fetchAll();

?>
<browser mix-update="#parks_container">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4 slide-in">
        <?php
        foreach ($parks as $park) {
            require __DIR__ . "../../views/components/__park-card.php";
        }
        ?></div>
</browser>