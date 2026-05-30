<?php require_once ROOT . "/config/_.php"; ?>
<browser mix-update="#update_avatar_container">
    <form mix-post="/api-update-avatar" enctype="multipart/form-data" class="flex flex-col items-center gap-6">
        <span class="flex justify-between gap-1 py-2 items-baseline border-b border-b-(--darkened-eggshell)">
            <label class="btn-secondary relative w-full!">
                Choose file
                <input type="file" name="user_avatar" placeholder="Select file" class="hidden absolute w-full h-full" accept="image/png, image/jpeg, image/jpg, image/webp">
            </label>
            <p class="xsmall">(<?php _("Max" . avatar_max_bytes_string) ?>)</p>
        </span>
        <div class="flex justify-between gap-2">
            <button class="btn-primary">Save</button>
            <div>
                <button mix-get="/api-cancel-update-avatar" class="btn-secondary w-full!">Cancel</button>
            </div>
        </div>
    </form>
</browser>