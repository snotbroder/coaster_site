<?php

// Fetch parks from DB
require_once __DIR__ . "../../config/db.php";
$sql = "SELECT * FROM parks";
$stmt = $_db->prepare($sql);
$stmt->execute();
$parks = $stmt->fetchAll();
