<?php
// Fetch next coasters from DB

require_once ROOT . "/config/db.php";
require_once ROOT . "/config/_.php";
$offset = (int)($_GET['offset'] ?? 6);
$sql = "SELECT * FROM coasters ORDER BY coaster_title ASC LIMIT 6 OFFSET $offset";
$stmt = $_db->prepare($sql);
$stmt->execute();
$coasters = $stmt->fetchAll();
//Get total of rows in coasters
$total_coasters = $_db->query("SELECT COUNT(*) FROM coasters")->fetchColumn();

?>
<browser mix-update="#coasters_container">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 slide-in">
        <?php
        foreach ($coasters as $coaster) {
            require ROOT . "/views/components/__coaster-card.php";
        }
        ?>
    </div>
    <browser mix-update="#pagination_count">
        <p class="my-4 small">Showing <?php _(count($coasters)) ?> of <?php _($total_coasters) ?> coasters</p>
    </browser>
</browser>

<browser mix-update="#pagination">
    <form mix-get="/api-pagination-coasters?offset=<?php _($offset - 6) ?>" method="GET"><button class="btn-secondary">Prev.</button></form>
    <form mix-get="/api-pagination-coasters?offset=<?php _($offset + 6) ?>" method="GET"><button class="btn-secondary">Next</button></form>
</browser>