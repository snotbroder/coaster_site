<?php
$title = "Login";
$active = "login";

require_once __DIR__ . '/components/_header.php';

?>

<main id="login-page">
    <h1>Login</h1>
    <p>Or you can <a class="underline" href="/sign-up">sign up</a></p>
    <form mix-post="/api-login" method="post">
        <div>
            <label for="user_email">User Email:</label>
            <input type="email" id="user_email" name="user_email" required autocomplete="none">
        </div>
        <div>
            <label for="user_password">Password:</label>
            <input type="password" id="user_password" name="user_password" required autocomplete="none">
        </div>
        <button type="submit" class="btn-primary">Login</button>
    </form>
</main>

<?php require_once __DIR__ . '/components/_footer.php'; ?>