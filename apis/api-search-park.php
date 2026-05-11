<?php
try {
    require_once __DIR__ . "/../config/db.php";
    require_once __DIR__ . "/../config/_.php";
    $q = $_POST["search"] ?? "";

    // Check if the search value is empty, then return all parks, else listen to search
    if ($q === "") {
        $sql = "SELECT * FROM parks ORDER BY park_title ASC LIMIT 6";
        $stmt = $_db->prepare($sql);
        $stmt->execute();
        $parks = $stmt->fetchAll();
    } else {
        _validate_search();
        $sql = "SELECT * FROM parks WHERE park_title LIKE :q ORDER BY park_title ASC LIMIT 6";
        $stmt = $_db->prepare($sql);
        $stmt->execute([":q" => "%" . $q . "%"]);
        $parks = $stmt->fetchAll();
    }

    if (empty($parks)) {
        _("no results");
    } else {
?>
        <browser mix-update="#parks_search_results">
            <?php
            if ($parks == []) {
                _("No parkss found matching the search");
                exit;
            }
            foreach ($parks as $park) {
                require __DIR__ . "../../views/components/__park-card.php";
            }
            ?>
        </browser>
        <?php if (count($parks) < 6): ?>
            <browser mix-hide="#parks_pagination"></browser>
        <?php else: ?>
            <browser mix-show="#parks_pagination"></browser>
        <?php endif; ?>
<?php
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
