<?php
// Fetch previous parks from DB

require_once __DIR__ . "../../config/db.php";
require_once __DIR__ . "../../config/_.php";
$offset = (int)($_GET['offset'] ?? 6);
$sql = "SELECT * FROM parks ORDER BY park_title ASC LIMIT 6 OFFSET $offset";
$stmt = $_db->prepare($sql);
$stmt->execute();
$parks = $stmt->fetchAll();

//Get total of rows in parks
$total_parks = $_db->query("SELECT COUNT(*) FROM parks")->fetchColumn();

?>
<browser mix-update="#parks_container">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 slide-in">
        <?php
        foreach ($parks as $park) {
            require __DIR__ . "../../views/components/__park-card.php";
        }
        ?>
    </div>
    <browser mix-update="#parks_pagination_count">
        <p class="my-4 small">Showing <?php _(count($parks)) ?> of <?php _($total_parks) ?> parks</p>
    </browser>
</browser>