<?php

$title = "Account";
$active = "account";

require_once ROOT . '/views/components/_header.php';
if (!$_SESSION) {
    header("Location: /");
    exit;
}
require_once ROOT . "/config/db.php";
$stmt = $_db->prepare("SELECT * FROM users WHERE user_email = :email");
$stmt->execute([":email" => $_SESSION["user_email"] ?? ""]);
$user = $stmt->fetch();

?>
<h1>Account</h1>
<section class="my-8 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4 lg:gap-8">
    <aside class="w-full flex flex-col gap-8 bg-(--pure-eggshell) p-6 rounded-md shadow-md">
        <div class="w-28 m-auto">
            <img class="object-fit rounded-full w-full" src="<?php _($user["user_avatar_path"] ?? "/static/assets/avatars/profile_avatar_default.jpg") ?>" alt="Profile image">
        </div>
        <span class="flex flex-col gap-1">
            <form id="update_avatar_container" mix-post="/api-request-update-avatar">

                <button class="btn-primary">Update avatar</button>

            </form>
            <button class="btn-secondary w-full!">Remove</button>
        </span>
        <div class="flex flex-col gap-4">
            <p><?php _($user["user_email"]) ?></p>
            <p class="small">Created <?php timeago($user["user_created_at"]) ?></p>
            <p class="small text-(--light-indigo)!">32 reviews</p>

        </div>
    </aside>
    <section class=" px-6 md:col-span-3 md:col-end-5">
        <h3>Profile</h3>
        <form mix-post="" class="default grid! grid-cols-2!">
            <div>
                <div>
                    <label for="">Username</label>
                    <input type="text" id="" name="">
                </div>
                <div>
                    <label for="user_password">Country</label>
                    <input type="password" id="user_password" name="user_password">
                </div>
            </div>
            <div>
                <div>
                    <label for="">Favourite park</label>
                    <input type="text" id="" name="">
                </div>

            </div>
            <span>
                <button class="btn-primary small">Save changes</button>
                <button class="btn-secondary small">Cancel</button>
            </span>
        </form>
    </section>
</section>


<?php require_once ROOT . "/views/components/_footer.php"; ?>