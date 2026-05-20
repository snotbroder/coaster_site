<?php

/** @var array $coaster */
// Im sorry, I have to use echo :(

$sql = "SELECT park_country_code FROM parks WHERE park_pk = :park_pk";
$stmt = $_db->prepare($sql);
$stmt->execute([":park_pk" => $coaster["coaster_park_fk"]]);
$coaster_country_code = $stmt->fetchColumn();

switch ($coaster_country_code) {
    case "AT":
        echo "<img src='/static/assets/icons/flag_At.svg' alt='Austria' class='object-cover aspect-square rounded-full'>";
        break;

    case "DE":
        echo "<img src='/static/assets/icons/flag_DE.svg' alt='Germany' class='object-cover aspect-square rounded-full'>";
        break;

    case "DK":
        echo "<img src='/static/assets/icons/flag_DK.svg' alt='Denmark' class='object-cover aspect-square rounded-full'>";
        break;

    case "FR":
        echo "<img src='/static/assets/icons/flag_FR.svg' alt='France' class='object-cover aspect-square rounded-full'>";
        break;

    case "NL":
        echo "<img src='/static/assets/icons/flag_NL.svg' alt='Netherlands' class='object-cover aspect-square rounded-full'>";
        break;

    case "PL":
        echo "<img src='/static/assets/icons/flag_PL.svg' alt='Poland' class='object-cover aspect-square rounded-full'>";
        break;

    case "SE":
        echo "<img src='/static/assets/icons/flag_SE.svg' alt='Sweden' class='object-cover aspect-square rounded-full'>";
        break;

    default:
        _("");
}
