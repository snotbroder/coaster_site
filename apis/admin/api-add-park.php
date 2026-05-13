<?php
// API endpoint to add a new coaster
require_once ROOT . "/config/db.php";
require_once ROOT . "/config/_.php";

// Get POST data
$title = $_POST["title"] ?? null;
$city = $_POST["city"] ?? null;
$country = $_POST["country"] ?? null;
$country_code = $_POST["country_code"] ?? null;
$year = $_POST["year"] ?? null;
$website = $_POST["website"] ?? null;
$slug = $_POST["slug"] ?? null;
$image_path = $_POST["image_path"] ?? null;
$lon = $_POST["lon"] ?? null;
$lat = $_POST["lat"] ?? null;
$is_operational = $_POST["is_operational"] ?? null;


// Validate required fields
if (!$title || !$country) {
    http_response_code(400);
    echo json_encode(["error" => 'Title is required']);
    exit;
}

$park_pk = uuidv4_nodash();
$park_created_at = time();
$park_deleted_at = 0;

// Insert coaster into DB
$sql = "INSERT INTO parks (park_pk, park_title, park_city, park_country, park_country_code, park_year, park_website, park_slug, park_image_path, park_lon, park_lat, park_is_operational, park_created_at, park_deleted_at) 
VALUES (:park_pk, :title, :city, :country, :country_code, :year, :website, :slug, :image_path, :lon, :lat, :is_operational, :park_created_at, :park_deleted_at)";
$stmt = $_db->prepare($sql);
$stmt->execute([
    ":park_pk" => $park_pk,
    ":title" => $title,
    ":city" => $city,
    ":country" => $country,
    ":country_code" => $country_code,
    ":year" => $year,
    ":website" => $website,
    ":slug" => $slug,
    ":image_path" => $image_path ?? null,
    ":lon" => $lon,
    ":lat" => $lat,
    ":is_operational" => $is_operational,
    ":park_created_at" => $park_created_at,
    ":park_deleted_at" => $park_deleted_at
]);
http_response_code(200);
echo json_encode(["message" => "Park added successfully"]);
