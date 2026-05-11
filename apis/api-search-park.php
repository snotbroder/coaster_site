<?php
try {
    require_once __DIR__ . "/../config/db.php";
    require_once __DIR__ . "/../config/_.php";
    $q = $_POST["search"] ?? "";
    _validate_search();

    $sql = "SELECT * FROM parks WHERE park_title LIKE :q ORDER BY park_title ASC LIMIT 3";
    $stmt = $_db->prepare($sql);
    $stmt->execute([":q" => "%" . $q . "%"]);
    $parks = $stmt->fetchAll();

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


<?php
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
