<?php
$review_pk = $_GET["review_pk"];
require_once ROOT . "/config/db.php";
require_once ROOT . "/config/_.php";

$stmt = $_db->prepare("SELECT * FROM reviews WHERE review_pk = :review_pk");
$stmt->execute([":review_pk" => $_GET["review_pk"] ?? ""]);
$review = $stmt->fetch();

?>
<browser mix-update="#review_content_<?php _($_GET["review_pk"]) ?>">
    <div>
        <form mix-post="/api-update-review?review_pk=<?php _($review["review_pk"]) ?>" class="default ">
            <textarea name="review_body" class="review-body border border-(--darkened-eggshell) p-2 rounded-sm" type="text"><?php _($review["review_body"]) ?></textarea>
            <span class="flex gap-2">

                <button class="btn-primary small w-fit">Save</button>
                <button type="button" mix-get="/api-cancel-update-review?review_pk=<?php _($review["review_pk"]) ?>" class="btn-secondary small w-fit">Cancel</button>
            </span>
        </form>
    </div>
</browser>