<?php

$title = "Account";
$active = "account";

if (!isset($_SESSION["user_pk"])) {
    header("Location: /login");
    exit;
}

require_once ROOT . "/config/db.php";
$stmt = $_db->prepare("SELECT * FROM users WHERE user_pk = :user_pk");
$stmt->execute([":user_pk" => $_SESSION["user_pk"]]);
$user = $stmt->fetch();



require_once ROOT . '/views/components/_header.php';
?>
<h1>Account</h1>
<section class="my-8 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4 lg:gap-8">
    <aside class="w-full flex flex-col gap-8 justify-between bg-(--pure-eggshell) p-6 rounded-md shadow-md">
        <div>
            <div id="avatar_image_container" class="w-28 mx-auto">
                <img class="object-fit rounded-full w-full" src="/static/assets/avatars/<?php _($_SESSION["user_avatar_path"] ?? "profile_avatar_default.jpg") ?>" alt="Profile image">
            </div>
            <span id="avatar_options_container" class="flex flex-col gap-1 mt-8">
                <section id="update_avatar_container" class="flex flex-col items-center">
                    <button mix-post="/api-request-update-avatar" class="btn-primary">Update avatar</button>
                </section>
            </span>
        </div>
        <div class="flex flex-col gap-4">
            <p><?php _($_SESSION["user_email"]) ?></p>
            <p class="small">Created <?php timeago($user["user_created_at"]) ?></p>
            <p class="small text-(--light-indigo)!">32 reviews</p>

        </div>
    </aside>
    <section class=" px-6 md:col-span-3 md:col-end-5">
        <section class="mb-10">
            <h3 class="mb-2">Profile</h3>
            <form mix-post="" class="default grid! grid-cols-2!">
                <div>
                    <div>
                        <label for="">Username</label>
                        <input type="text" id="user_username" name="user_username" value="<?php _($_SESSION["user_username"]) ?>">
                    </div>
                    <div>
                        <label for="">Country</label>
                        <input type="password" id="" name="">
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
        <section>
            <h3 class="mb-2">Danger zone</h3>
            <article class="w-full flex flex-col gap-6 bg-(--system-failure)/5 border-2 border-(--system-failure)/30 rounded-md p-8">
                <p>When you delete your account, your reviews will be removed from the website.</p>
                <p class="small">If you have questions regarding your data, feel free to <a class="hyperlink-mini" href="#">contact us</a>.</p>
                <button class="btn-primary danger">Delete profile</button>
            </article>
        </section>
    </section>


</section>


<?php require_once ROOT . "/views/components/_footer.php"; ?>