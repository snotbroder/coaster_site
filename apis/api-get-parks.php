<?php

// Fetch parks from DB
require_once ROOT . "/config/db.php";
$sql = "SELECT * FROM parks ORDER BY park_title ASC LIMIT 6";
$stmt = $_db->prepare($sql);
$stmt->execute();
$parks = $stmt->fetchAll();
