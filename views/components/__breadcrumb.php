<?php
require_once ROOT . "/config/_.php";
require_once ROOT . "/config/db.php";

if ($active == "index") {
    // Do nothinhg
} else {

    $breadcrumb_1 = ucfirst($active);
    $current_subpage = $_GET["park"] ?? $_GET["coaster"] ?? NULL;


    if (isset($_GET["park"])) {
        $sql = "SELECT park_title FROM parks WHERE :park_slug = park_slug";
        $stmt = $_db->prepare($sql);
        $stmt->execute([":park_slug" => $current_subpage]);
        $current_subpage = $stmt->fetchColumn();
    }

    // Get coaster title based on param uuid
    if (isset($_GET["coaster"])) {
        $sql = "SELECT coaster_title FROM coasters WHERE :coaster_pk = coaster_pk";
        $stmt = $_db->prepare($sql);
        $stmt->execute([":coaster_pk" => $current_subpage]);
        $current_subpage = $stmt->fetchColumn();
    }
?>
    <nav class="my-2 md:my-4 ">
        <ul class="flex flex-row gap-3 breadcrumb-list">
            <li class="breadcrumb"><a href="/">Home</a></li>
            <li class="breadcrumb"><a href="/<?php _($active); ?>"><?php _($breadcrumb_1); ?></a></li>
            <?php if ($current_subpage): ?>
                <li class="breadcrumb capitalize"><?php _($current_subpage); ?></a></li>
            <?php endif ?>
        </ul>
    </nav>

<?php
}
