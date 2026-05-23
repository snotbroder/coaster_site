<?php

/** @var array $review */

// Get user data based on review_user_fk
$review_user_fk = $review["review_user_fk"];
$stmt = $_db->prepare("SELECT * FROM users WHERE user_pk = :review_user_fk");
$stmt->execute([":review_user_fk" => $review_user_fk ?? ""]);
$review_user = $stmt->fetch();
?>
<article id="review_<?php _($review['review_pk']) ?>" class="transition-all duration-300 ease-in-out">
    <!-- Two articles, one for mixhtml to remove upon delete, the other for styling -->
    <article class="relative bg-(--pure-eggshell) p-4 rounded-md flex flex-col gap-2 md:gap-4 shadow-sm transition-discrete transition-all">
        <div class="flex flex-col gap-1 md:gap-2">
            <div class="flex justify-between">
                <div class="w-5 h-auto flex gap-3 items-center">
                    <img class="object-fit rounded-full" src="/static/assets/avatars/<?php _($_SESSION["user_avatar_path"] ?? "/static/assets/avatars/profile_avatar_default.jpg") ?>" alt="Profile image">
                    <p class="small text-(--light-indigo)!"><?php _($review_user["user_username"]); ?></p>
                </div>
                <div class="flex gap-2 items-center">
                    <div class="relative z-50">
                        <input type="checkbox" id="review_dropdown_<?php _($review['review_pk']) ?>" class="hidden peer">
                        <label for="review_dropdown_<?php _($review["review_pk"]) ?>" class="cursor-pointer">
                            <span aria-label="button" class="btn-utility text-xl pl-3.5! py-1! rounded-full!">&#x2807;</span>
                        </label>
                        <div class="hidden peer-checked:flex absolute right-0 top-full mt-1 z-100 min-w-36 flex-col gap-2 rounded-md border border-(--darkened-eggshell) bg-(--pure-eggshell) p-2 px-4 shadow-lg">
                            <?php if ($review_user_fk === $_SESSION["user_pk"]): ?>
                                <form mix-post="/api-request-update-review?review_pk=<?php _($review["review_pk"]) ?>">
                                    <button class="btn-utility">Edit</button>
                                </form>
                                <form id="review_delete_btn_<?php _($review["review_pk"]) ?>" mix-post="/api-request-delete-review?review_pk=<?php _($review["review_pk"]) ?>">
                                    <button class="btn-utility text-(--system-failure)!">Delete</button>
                                </form>
                            <?php else: ?>
                                <form mix-post="/api-report-review">
                                    <button class="btn-utility text-(--system-failure)!">Report</button>
                                </form>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
            <article id="review_content_<?php _($review["review_pk"]) ?>">
                <div class="flex gap-3 items-center">
                    <span class="text-(--light-indigo) flex gap-1 items-center">
                        <?php $rating = $review["review_rating"]; require ROOT . "/views/components/___rating-stars.php" ?>
                        <p class="small"> <?php _($review["review_rating"]) ?> / 5</p>
                    </span>
                    <p class="xsmall text-(--light-indigo)!"><?php timeago($review["review_created_at"]) ?></p>
                </div>
                <p><?php _($review["review_body"]) ?></p>
            </article>
        </div>
    </article>
</article>