<?php
$title = "Configure Coasters";
$active = "configure-coasters";

require_once __DIR__ . "../../config/_.php";
require_once ROOT . "/config/db.php";

// Get all parks for the dropdown
$sql = "SELECT * FROM parks ORDER BY park_title ASC";
$stmt = $_db->prepare($sql);
$stmt->execute();
$parks = $stmt->fetchAll();




require_once __DIR__ . '/components/admin/_admin-header.php';
?>

<h1>Add coaster</h1>
<form action="/api-add-coaster" method="POST">
    <section class="grid grid-cols-2 gap-4">
        <div>
            <select name="park" aria-placeholder="select">
                <option value="">Select a park</option>
                <?php foreach ($parks as $park): ?>
                    <option value="<? _($park['park_pk']) ?>"><? _($park['park_title']) ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="title" placeholder="Coaster title">
            <input type="text" name="model" placeholder="Coaster model">
            <input type="text" name="manufacturer" placeholder="Coaster manufacturer">
            <input type="text" name="year" placeholder="Coaster year">

            <input type="number" step=".01" name="height" placeholder="Height (m)">
            <input type="number" step=".01" name="length" placeholder="Length (m)">
        </div>
        <div>
            <span class="flex gap-2">
                <label for="is_operational">Is Operational:</label>
                <select name="is_operational">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </span>
            <span class="flex gap-1">
                <input class="" type="text" name="lon" placeholder="Longitude">
                <input class="" type="text" name="lat" placeholder="Latitude">
            </span>
            <input type="text" name="top_speed" placeholder="Top speed (km/h)">
            <input type="number" step=".01" name="gforce" placeholder="G-Force">
            <input type="text" name="duration" placeholder="Duration (mm:ss)">
            <input type="number" name="inversions" placeholder="Inversions">
            <textarea type="text" name="image_path" placeholder="Image path"></textarea>


        </div>
        <div>
            <textarea type="text" name="description" placeholder="Description"></textarea>
        </div>
    </section>
    <button class="btn-primary">Add Coaster</button>
</form>
<section id="feedback"></section>



<?php
require_once __DIR__ . '/components/admin/_admin-footer.php';
