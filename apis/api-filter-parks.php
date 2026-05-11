<?php
require_once ROOT . "/config/db.php";

$country_code = $_POST["filter_country_code"] ?? "";
$operational_only = isset($_POST["filter_is_operational"]) && $_POST["filter_is_operational"] === "on";
$min_coasters = $_POST["filter_min_coasters"] ?? "";

$sql = "SELECT parks.* FROM parks LEFT JOIN coasters ON parks.park_pk = coasters.park_fk WHERE 1=1";
$params = [];

if ($country_code !== "" && $country_code !== "all") {
    $sql .= " AND park_country_code = :country_code";
    $params[":country_code"] = $country_code;
}

if ($operational_only) {
    $sql .= " AND park_is_operational = 1";
}

$sql .= " GROUP BY parks.park_pk";

if ((int)$min_coasters > 0) {
    $sql .= " HAVING COUNT(coasters.coaster_pk) >= :min_coasters";
    $params[":min_coasters"] = (int)$min_coasters;
}

$sql .= " ORDER BY park_title ASC";

$stmt = $_db->prepare($sql);
$stmt->execute($params);
$parks = $stmt->fetchAll();

header("Content-Type: application/json");
echo json_encode($parks);
