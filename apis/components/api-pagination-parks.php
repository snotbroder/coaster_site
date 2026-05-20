<?php
// Fetch next parks from DB

require_once ROOT . "/config/db.php";
require_once ROOT . "/config/_.php";
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
            require ROOT . "/views/components/__park-card.php";
        }
        ?>
    </div>
    <browser mix-update="#pagination_count">
        <p class="my-4 small">Showing <?php _(count($parks)) ?> of <?php _($total_parks) ?> parks</p>
    </browser>
</browser>

<browser mix-update="#pagination">
    <form mix-get="/api-pagination-parks?offset=<?php _($offset - 6) ?>" method="GET"><button class="btn-secondary">Prev.</button></form>
    <form mix-get="/api-pagination-parks?offset=<?php _($offset + 6) ?>" method="GET"><button class="btn-secondary">Next</button></form>
</browser>