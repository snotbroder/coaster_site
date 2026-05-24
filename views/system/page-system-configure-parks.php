<?php
$title = "Configure Parks";
$active = "configure-parks";

require_once ROOT . "/config/db.php";

// Get all countries for the dropdown
$sql_countries = "SELECT DISTINCT park_country FROM parks ORDER BY park_country ASC";
$sql_country_codes = "SELECT DISTINCT park_country_code FROM parks ORDER BY park_country_code ASC";

$stmt = $_db->prepare($sql_countries);
$stmt->execute();
$countries = $stmt->fetchAll();

$stmt = $_db->prepare($sql_country_codes);
$stmt->execute();
$country_codes = $stmt->fetchAll();



require_once ROOT . "/views/components/system/_system-header.php";
?>
<section class="my-18">
    <h1>Add park</h1>
    <form action="/api-add-park" method="POST" class="default">
        <section class="grid grid-cols-2 gap-4">
            <div>
                <input type="text" name="title" placeholder="Park title">
                <input type="text" name="city" placeholder="City">
                <select name="country" aria-placeholder="select">
                    <option value="">Select a country</option>
                    <?php foreach ($countries as $country): ?>
                        <option value="<? _($country["park_country"]) ?>"><? _($country["park_country"]) ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="country_code" aria-placeholder="select">
                    <option value="">Select a country code</option>
                    <?php foreach ($country_codes as $code): ?>
                        <option value="<? _($code["park_country_code"]) ?>"><? _($code["park_country_code"]) ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="year" placeholder="Opening year">
                <input type="text" name="website" placeholder="Website url">

            </div>
            <div>
                <input type="text" name="slug" placeholder="Custom slug">
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
                <textarea type="text" name="image_path" placeholder="Image path"></textarea>


            </div>

        </section>
        <button class="btn-primary">Add Park</button>
    </form>
</section>



<?php
require_once ROOT . "/views/components/_footer.php";
