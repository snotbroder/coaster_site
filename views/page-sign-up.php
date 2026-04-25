<?php
$title = "Sign Up";
$active = "sign-up";

require_once __DIR__ . '/components/_header.php';

?>

<main id="sign-up-page">
    <h1>Sign Up</h1>
    <p>Or you can <a class="underline" href="/login">login</a></p>
    <form mix-post="/api-sign-up" method="post">
        <div>
            <label for="user_email">User Email:</label>
            <input type="email" id="user_email" name="user_email" required autocomplete="none">
        </div>
        <div>
            <label for="user_password">Password:</label>
            <input type="password" id="user_password" name="user_password" required autocomplete="none">
        </div>
        <div>
            <label for="user_confirm_password">Confirm Password:</label>
            <input type="password" id="user_confirm_password" name="user_confirm_password" required autocomplete="none">
        </div>
        <button type="submit" class="btn-primary">Sign Up</button>
    </form>
</main>

<?php require_once __DIR__ . '/components/_footer.php'; ?>