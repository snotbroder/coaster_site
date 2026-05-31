<?php

// Fetch coaster from DB
require_once ROOT . "/config/db.php";
$sql = "SELECT * FROM coasters ORDER BY coaster_title ASC LIMIT 6";
$stmt = $_db->prepare($sql);
$stmt->execute();
$coasters = $stmt->fetchAll();
