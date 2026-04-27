<?php
require_once __DIR__ . "../../../config/_.php";

if ($active == "index") {
    // Do nothinhg
} else {
    $breadcrumb_1 = ucfirst($active);
?>
    <nav class="mb-9 bg-red-500">
        <ul class=" flex flex-row gap-3 breadcrumb-list">
            <li class="breadcrumb"><a href="/">Home</a></li>
            <li class="breadcrumb"><a href="/<?php _($active); ?>"><?php _($breadcrumb_1); ?></a></li>
        </ul>
    </nav>

<?php
}
