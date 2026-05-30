<?php

require_once ROOT . "/config/db.php";
require_once ROOT . "/config/_.php";

$mode = $_GET["switch"] ?? "coasters";

if ($mode === "parks") {
    require_once ROOT . "/models/ParkFilterModel.php";
    $query = new ParkFilterModel();
} else {
    require_once ROOT . "/models/CoasterFilterModel.php";
    $query = new CoasterFilterModel();
}

if (!empty($_GET["filter_country"]) && $_GET["filter_country"] !== "all") {
    $query->filterCountry($_GET["filter_country"]);
}

if (!empty($_GET["filter_search"]) && $_GET["filter_search"] !== "") {
    $query->filterSearch(_validate_search());
}

if ($mode === "coasters" && !empty($_GET["top_speed"])) {
    $query->filterMinTopSpeed((int)$_GET["top_speed"]);
}

$results = $query->fetch($_db);

header("Content-Type: application/json");
echo json_encode($results);
