<?php
$title = "Sign Up";
$active = "sign-up";

require_once __DIR__ . '/components/_header.php';

?>

<section id="sign-up-page" class="utility-form-container">
    <aside>
        <h1>Sign Up</h1>
        <p>Or you can <a class="underline" href="/login">login</a></p>
        <div class="relative top-6" id="toast-container">
    </aside>
    <form mix-post="/api-sign-up" method="post" class="utility-form">
        <div>
            <label for="user_email">Email</label>
            <input type="email" id="user_email" name="user_email" required autocomplete="new-email">
        </div>
        <div>
            <label for="user_password">Password</label>
            <input type="password" id="user_password" name="user_password" required autocomplete="new-password">
        </div>
        <div>
            <label for="user_confirm_password">Confirm Password</label>
            <input type="password" id="user_confirm_password" name="user_confirm_password" required autocomplete="new-password">
        </div>
        <button type="submit" class="btn-primary">Sign Up</button>
    </form>
</section>

<?php require_once __DIR__ . '/components/_footer.php'; ?>