<?php
$title = "Login";
$active = "login";

if ($_SESSION) {
    header("Location: /");
    exit;
}

require_once __DIR__ . '/components/_header.php';

?>

<section id="login-page" class="utility-form-container">
    <aside>
        <h1>Login</h1>
        <p>Or you can <a class="underline" href="/sign-up">sign up</a></p>
        <div class="relative top-6" id="toast-container">
        </div>
    </aside>
    <form mix-post="/api-login" method="post" class="default utility-form">
        <div>
            <label for="user_email">Email</label>
            <input type="email" id="user_email" name="user_email" required>
        </div>
        <div>
            <label for="user_password">Password</label>
            <input type="password" id="user_password" name="user_password" required>
        </div>
        <button type="submit" class="btn-primary">Login</button>
    </form>
</section>

<?php require_once __DIR__ . '/components/_footer.php'; ?>