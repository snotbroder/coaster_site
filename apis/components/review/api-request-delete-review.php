<?php
require_once ROOT . "/config/_.php";
$review_pk = $_GET["review_pk"] ?? "";
?>
<browser mix-update="#review_delete_btn_<?php _($review_pk) ?>">
    <button mix-post="/api-delete-review?review_pk=<?php _($review_pk) ?>" class="btn-utility bg-(--system-failure)! text-(--pure-eggshell)">Confirm</button>
</browser>