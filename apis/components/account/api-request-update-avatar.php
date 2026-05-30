<browser mix-update="#update_avatar_container">
    <form mix-post="/api-update-avatar" enctype="multipart/form-data" class="flex flex-col items-center gap-6">
        <span>
            <label class="btn-secondary relative w-full!">
                Choose file
                <input type="file" name="user_avatar" placeholder="Select file" class="hidden absolute w-full h-full" accept="image/png, image/jpeg, image/jpg, image/webp">
            </label>
        </span>
        <div class="flex justify-between gap-2">
            <button class="btn-primary">Save</button>
            <div>
                <button mix-get="/api-cancel-update-avatar" class="btn-secondary w-full!">Cancel</button>
            </div>
        </div>
    </form>
    <!-- <div>
        <button mix-get="/api-cancel-update-avatar" class="btn-secondary w-full!">Cancel</button>
    </div> -->
</browser>