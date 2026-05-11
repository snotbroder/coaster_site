<?php
try {
    require_once __DIR__ . "/../config/db.php";
    require_once __DIR__ . "/../config/_.php";
    $q = $_POST["search"] ?? "";
    _validate_search();

    $sql = "SELECT * FROM coasters WHERE coaster_title LIKE :q ORDER BY coaster_title ASC LIMIT 3";
    $stmt = $_db->prepare($sql);
    $stmt->execute([":q" => "%" . $q . "%"]);
    $coasters = $stmt->fetchAll();

    if (empty($coasters)) {
        echo "no results";
    } else {
?>
        <browser mix-update="#index_search_results">
            <?php
            if ($coasters == []) {
                _("No coasters found matching the search");
                exit;
            }
            foreach ($coasters as $coaster) {
                require __DIR__ . "../../views/components/__coaster-card.php";
            }
            ?>
            <article class="place-self-center"><a class="btn-secondary " href="/parks">Browse parks</a></article>
        </browser>


<?php
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
