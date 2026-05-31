<?php

/** @var array $user 
 */
?>
<article class="bg-(--pure-eggshell) shadow-md rounded-md w-full max-w-74 h-48 p-4 flex flex-col justify-between">
    <div class="grid grid-cols-4">
        <div class="w-10 m-auto">
            <img class="object-fit rounded-full" src="/static/assets/avatars/<?php _($user["user_avatar_path"] ?? "/static/assets/avatars/profile_avatar_default.jpg") ?>" alt="Profile image">
        </div>
        <div class="col-2 span-3">
            <h5><?php _($user["user_username"]) ?></h5>
            <p class="xsmall"><?php _($user["user_email"]) ?></p>
        </div>
    </div>
    <span>
        <?php if ($user["user_deleted_at"] > 0): ?>
            <button class="btn-primary">Reactivate</button>
        <?php else: ?>
            <button class="btn-primary danger">Deactivate</button>

        <?php endif; ?>
    </span>
</article>