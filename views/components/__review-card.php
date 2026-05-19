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
    <article class="bg-(--pure-eggshell) p-4 rounded-md flex flex-col gap-2 md:gap-4 shadow-sm transition-discrete transition-all">
        <div class="flex flex-col gap-1 md:gap-2">
            <div class="flex justify-between">
                <div class="w-5 h-auto flex gap-3 items-center">
                    <img class="object-fit rounded-full" src="<?php _($_SESSION["user_avatar_path"] ?? "/static/assets/avatars/profile_avatar_default.jpg") ?>" alt="Profile image">
                    <p class="small text-(--light-indigo)!"><?php _($review_user["user_email"]); ?></p>
                </div>
                <div class="flex gap-2 items-center">

                    <details class="relative z-100 isolate" name="review-utility">
                        <summary class="small text-(--light-indigo)! cursor-pointer list-none flex gap-2 place-items-center ">
                            <span aria-label="button" class="btn-utility text-xl">&#x2807;</span>
                        </summary>
                        <div class="absolute right-0 top-full mt-1 z-100 min-w-36 flex flex-col gap-2 rounded-md border border-(--darkened-eggshell) bg-(--eggshell) p-2 px-4 shadow-lg">
                            <form action="flex">
                                <button class="btn-utility ">Edit</button>
                            </form>
                            <form id="review_delete_btn_<?php _($review['review_pk']) ?>" mix-post="/api-request-delete-review?review_pk=<?php _($review['review_pk']) ?>">
                                <button class="btn-utility text-(--system-failure)!">Delete</button>
                            </form>
                        </div>
                    </details>
                </div>
            </div>
            <div class="flex gap-2 items-center">
                <span class="text-(--light-indigo)">
                    <?php require ROOT . "/views/components/___rating-stars.php" ?>
                </span>
                <p class="xsmall text-(--light-indigo)!"><?php timeago($review["review_created_at"]) ?></p>
            </div>
        </div>
        <p><?php _($review["review_body"]) ?></p>
    </article>
</article>