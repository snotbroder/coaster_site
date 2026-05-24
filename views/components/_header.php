<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coaster Site | <?= $title ?? '' ?></title>
    <link href="/static/css/output.css" rel="stylesheet">
    <link href="/static/css/styles.css" rel="stylesheet">
    <link href="/static/css/globals.css" rel="stylesheet">
    <link href="/static/css/animations.css" rel="stylesheet">

    <script src="/static/js/mixhtml.js" defer></script>
    <script src="/static/js/script.js" defer></script>

    <!-- LEaflet map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
    <script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
    <script src="//unpkg.com/leaflet-gesture-handling"></script>
    <link rel="stylesheet" href="//unpkg.com/leaflet-gesture-handling/dist/leaflet-gesture-handling.min.css" type="text/css">
    <?php require_once ROOT . "/config/_.php"; ?>

</head>

<body>
    <header class="w-full ">
        <nav class="flex justify-between md:grid sm:grid-cols-3 lg:grid-cols-5 items-center">
            <a href="/"><img class="logo" src="../../static/assets/logo.svg" alt="Logo"></a>

            <!-- Desktop nav links -->
            <ul class="hidden md:flex flex-row gap-1 justify-between md:col-2 lg:col-3">
                <li><a href="/parks" class="head-link <?= $active == 'parks' ? 'header-link-active' : '' ?>">Parks</a></li>
                <li><a href="/coasters" class="head-link <?= $active == 'coasters' ? 'header-link-active' : '' ?>">Coasters</a></li>
                <li><a href="/map" class="head-link <?= $active == 'map' ? 'header-link-active' : '' ?>">Map</a></li>
            </ul>

            <!-- Desktop auth -->
            <ul class="hidden md:flex md:justify-end md:col-3 lg:col-5">
                <li class="flex place-items-end">
                    <?php if ($_SESSION["user_email"] ?? false) : ?>
                        <div class="relative">
                            <input type="checkbox" id="user_dropdown" class="hidden peer">
                            <label for="user_dropdown" class="small text-(--light-indigo)! cursor-pointer flex gap-2 place-items-center">
                                <?php _($_SESSION["user_username"]) ?>
                                <?php if ($_SESSION["user_authority"] == 1): ?>
                                    <span>(admin)</span>
                                <?php endif; ?>
                                <div class="w-6">
                                    <img class="object-fit rounded-full" src="/static/assets/avatars/<?php _($_SESSION["user_avatar_path"] ?? "profile_avatar_default.jpg") ?>" alt="Profile image">
                                </div>
                            </label>
                            <div class="hidden peer-checked:flex absolute right-0 top-full mt-1 z-100 min-w-48 flex-col gap-4 rounded-md border border-(--darkened-eggshell) bg-(--pure-eggshell) p-4 shadow-lg">
                                <?php if ($_SESSION["user_authority"] == 1): ?>
                                    <div class="border-b border-(--darkened-eggshell) py-4">
                                        <a class="btn-secondary flex gap-2 justify-between px-2! w-full!" href="/system"><span>System panel</span><img class="w-4" src="/static/assets/icons/admin-user.svg" alt="admin user icon"></a>
                                    </div>
                                <?php endif; ?>
                                <a class="hyperlink flex gap-4" href="/account"><img class="w-5" src="/static/assets/icons/account.svg" alt="account icon"><span>Account</span></a>
                                <a class="hyperlink flex gap-4" href="/my-reviews"><img class="w-5" src="/static/assets/icons/my-reviews.svg" alt="reviews icon"><span>My reviews</span></a>
                                <a class="hyperlink flex gap-4" href="/"><img class="w-5" src="/static/assets/icons/contact-us.svg" alt="contact us icon"><span>Contact us</span></a>
                                <form mix-post="api-logout ">
                                    <button class="btn-primary w-full">Logout</button>
                                </form>
                            </div>
                        </div>
                    <?php else : ?>
                        <?php if ($active == "login") : ?>
                            <a href="/sign-up" class="btn-primary">Sign Up</a>
                        <?php endif; ?>
                        <?php if ($active !== "login") : ?>
                            <a href="/login" class="btn-primary">Login</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </li>
            </ul>

            <!-- Burger button (mobile only) -->
            <button id="burger-btn" class="md:hidden flex flex-col gap-1.5 p-2 cursor-pointer" aria-label="Toggle navigation" aria-expanded="false">
                <span class="burger-line"></span>
                <span class="burger-line"></span>
                <span class="burger-line"></span>
            </button>
        </nav>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden">

            <ul class="flex flex-col gap-1 pt-4 pb-2">
                <li class="anim-slide-in"><a href="/parks" class="head-link block py-2 <?= $active == 'parks' ? 'header-link-active' : '' ?>">Parks</a></li>
                <li class="anim-slide-in"><a href="/coasters" class="head-link block py-2 <?= $active == 'coasters' ? 'header-link-active' : '' ?>">Coasters</a></li>
                <li class="anim-slide-in"><a href="/map" class="head-link block py-2 <?= $active == 'map' ? 'header-link-active' : '' ?>">Map</a></li>
            </ul>
            <div class="pt-3 pb-1 border-t border-(--darkened-eggshell)">
                <?php if ($_SESSION["user_email"] ?? false) : ?>
                    <div class="flex gap-4 justify-between items-center flex-wrap">
                        <a href="/account" class="text-(--light-indigo)! cursor-pointer list-none flex gap-2 place-items-center z-100">
                            <div class="w-6">
                                <img class="object-fit rounded-full" src="/static/assets/avatars/<?php _($_SESSION["user_avatar_path"] ?? "profile_avatar_default.jpg") ?>" alt="Profile image">
                            </div>

                            <?php _($_SESSION["user_username"]) ?>
                        </a>
                        <form mix-post="/api-logout">
                            <button class="btn-primary">Logout</button>
                        </form>
                    </div>
                    <?php if ($_SESSION["user_authority"] == 1): ?>
                        <div class="border-y border-(--darkened-eggshell) py-4 my-6">
                            <a class="btn-secondary flex gap-2" href="/system"><span>System panel</span><img class="w-4" src="/static/assets/icons/admin-user.svg" alt="admin user icon"></a>
                        </div>
                    <?php endif; ?>
                    <ul class="my-4 mt-8 flex flex-col gap-4">
                        <li><a class="hyperlink flex gap-4" href="/account"><img class="w-5" src="/static/assets/icons/account.svg" alt="account icon"><span>Account</span></a></li>
                        <li><a class="hyperlink flex gap-4" href="/my-reviews"><img class="w-5" src="/static/assets/icons/my-reviews.svg" alt="reviews icon"><span>My reviews</span></a></li>
                        <li><a class="hyperlink flex gap-4" href="/"><img class="w-5" src="/static/assets/icons/contact-us.svg" alt="contact us icon"><span>Contact us</span></a></li>

                    </ul>
                <?php else : ?>
                    <?php if ($active == "login") : ?>
                        <a href="/sign-up" class="btn-primary">Sign Up</a>
                    <?php endif; ?>
                    <?php if ($active !== "login") : ?>
                        <a href="/login" class="btn-primary">Login</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

        </div>
    </header>

    <main>
        <?php require_once __DIR__ . "/__breadcrumb.php"; ?>
        <div class="fixed top-12 right-2 z-100" id="toast-container-header"></div>