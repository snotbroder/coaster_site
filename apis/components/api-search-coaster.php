<?php
try {
    require_once ROOT . "/config/db.php";
    require_once ROOT . "/config/_.php";
    $q = _validate_search();

    //Get total of rows in coasters
    $total_coasters = $_db->query("SELECT COUNT(*) FROM coasters")->fetchColumn();

    // Check if the search value is empty, then return all coasters, else listen to search
    if ($q === "") {
        $sql = "SELECT * FROM coasters ORDER BY coaster_title ASC LIMIT 6";
        $stmt = $_db->prepare($sql);
        $stmt->execute();
        $coasters = $stmt->fetchAll();
    } else {

        $sql = "SELECT * FROM coasters WHERE coaster_title LIKE :q ORDER BY coaster_title ASC LIMIT 6";
        $stmt = $_db->prepare($sql);
        $stmt->execute([":q" => "%" . $q . "%"]);
        $coasters = $stmt->fetchAll();
    }

    if (empty($coasters)) {
        _("no results");
    } else {
?>
        <browser mix-update="#coasters_search_results">
            <?php
            if ($coasters == []) {
                _("No coasters found matching the search");
                exit;
            }
            foreach ($coasters as $coaster) {
                require ROOT . "/views/components/__coaster-card.php";
            }
            ?>
        </browser>
        <browser mix-update="#pagination_count">
            <p class="my-4 small">Showing <?php _(count($coasters)) ?> of <?php _($total_coasters) ?> coasters</p>
        </browser>
        <?php if (count($coasters) < 6): ?>
            <browser mix-hide="#pagination"></browser>
        <?php else: ?>
            <browser mix-show="#pagination"></browser>
        <?php endif; ?>
<?php
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
