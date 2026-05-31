<?php
require_once ROOT . "/config/db.php";
require_once ROOT . "/config/_.php";

require_once ROOT . "/models/CoasterFilterModel.php";
$query = new CoasterFilterModel();

if (!empty($_GET["filter_country"]) && $_GET["filter_country"] !== "all") {
    $query->filterCountry($_GET["filter_country"]);
}



if (!empty($_GET["filter_speed"]) && $_GET["filter_speed"] !== "all") {
    $query->filterMinTopSpeed((int)$_GET["filter_speed"]);
}

$results = $query->fetch($_db);

header("Content-Type: application/json");
echo json_encode($results);
