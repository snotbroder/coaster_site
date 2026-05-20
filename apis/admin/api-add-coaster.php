<?php
// API endpoint to add a new coaster
require_once ROOT . "/config/db.php";
require_once ROOT . "/config/_.php";

// Get POST data
$park = $_POST["park"] ?? null;
$title = $_POST["title"] ?? null;
$model = $_POST["model"] ?? null;
$manufacturer = $_POST["manufacturer"] ?? null;
$year = $_POST["year"] ?? null;
$height = $_POST["height"] ?? null;
$length = $_POST["length"] ?? null;
$is_operational = $_POST["is_operational"] ?? null;
$top_speed = $_POST["top_speed"] ?? null;
$gforce = $_POST["gforce"] ?? null;
$duration = $_POST["duration"] ?? null;
$inversions = $_POST["inversions"] ?? null;
$image_path = $_POST["image_path"] ?? null;
$description = $_POST["description"] ?? null;
$lon = $_POST["lon"] ?? null;
$lat = $_POST["lat"] ?? null;

// Validate required fields
if (!$park || !$title) {
    http_response_code(400);
?>
    <browser mix-update="#feedback">
        <p class="p-4 bg-(--system-failure)">Failed: Please add park and title </p>
    </browser>
<?php
    exit;
}

$coaster_pk = uuidv4_nodash();
$coaster_created_at = time();
$coaster_deleted_at = 0;

// Insert coaster into DB
$sql = "INSERT INTO coasters (coaster_pk, coaster_park_fk, coaster_title, coaster_model, coaster_manufacturer, coaster_year, coaster_height, coaster_length, coaster_top_speed, coaster_gforce, coaster_duration, coaster_inversion_count, coaster_image_path, coaster_is_operational, coaster_description, coaster_lon, coaster_lat, coaster_created_at, coaster_deleted_at) 
VALUES (:coaster_pk, :park, :title, :model, :manufacturer, :year, :height, :length, :top_speed, :gforce, :duration, :inversions, :image_path, :is_operational, :coaster_description, :coaster_lon, :coaster_lat, :coaster_created_at, :coaster_deleted_at)";
$stmt = $_db->prepare($sql);
$stmt->execute([
    ":park" => $park,
    ":coaster_pk" => $coaster_pk,
    ":title" => $title,
    ":model" => $model,
    ":manufacturer" => $manufacturer,
    ":year" => $year,
    ":height" => $height,
    ":length" => $length,
    ":top_speed" => $top_speed,
    ":gforce" => $gforce,
    ":duration" => $duration,
    ":inversions" => $inversions,
    ":image_path" => $image_path ?? null,
    ":is_operational" => $is_operational,
    ":coaster_description" => $description,
    ":coaster_lon" => $lon,
    ":coaster_lat" => $lat,
    ":coaster_created_at" => $coaster_created_at,
    ":coaster_deleted_at" => $coaster_deleted_at
]);
http_response_code(200);
echo json_encode(["message" => "Coaster added successfully"]);
?>
<browser mix-update="#feedback">
    <p class="p-4 bg-(--system-success)">Coaster added successfully</p>
    <a href="/admin/configure-coasters" class="btn-primary">Add another coaster</a>
</browser>