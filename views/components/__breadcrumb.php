<?php
require_once ROOT . "/config/_.php";

if ($active == "index") {
    // Do nothinhg
} else {
    $breadcrumb_1 = ucfirst($active);

    $current_coaster = $_GET["park"] ?? null;
?>
    <nav>
        <ul class="flex flex-row gap-3 breadcrumb-list">
            <li class="breadcrumb"><a href="/">Home</a></li>
            <li class="breadcrumb"><a href="/<?php _($active); ?>"><?php _($breadcrumb_1); ?></a></li>
            <?php if ($current_coaster): ?>
                <li class="breadcrumb capitalize"><?php _($current_coaster); ?></a></li>
            <?php endif ?>
        </ul>
    </nav>

<?php
}
