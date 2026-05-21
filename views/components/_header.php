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
                        <details class="relative">
                            <summary class="small text-(--light-indigo)! cursor-pointer list-none flex gap-2 place-items-center z-100">

                                <?php _($_SESSION["user_email"]) ?>
                                <div class="w-6">
                                    <img class="object-fit rounded-full" src="<?php _($_SESSION["user_avatar_path"] ?? "/static/assets/avatars/profile_avatar_default.jpg") ?>" alt="Profile image">
                                </div>
                            </summary>
                            <div class="absolute right-0 top-full mt-1 z-100 min-w-48 flex flex-col gap-4 rounded-md border border-(--darkened-eggshell) bg-(--eggshell) p-4 shadow-lg">
                                <a href="/account" class="hyperlink">Account</a>
                                <a href="/account#reviews" class="hyperlink">My reviews</a>
                                <a href="/contact" class="hyperlink">Contact us</a>
                                <form mix-post="api-logout">
                                    <button class="btn-primary">Logout</button>
                                </form>
                            </div>
                        </details>
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
                        <p class="text-(--light-indigo)!">
                            Hello
                            <a href="/profile" class="hyperlink"><?php _($_SESSION["user_email"]) ?></a>!
                        </p>
                        <form mix-post="api-logout">
                            <button class="btn-secondary">Logout</button>
                        </form>
                    </div>
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

    <script>

    </script>
    <main>
        <?php require_once __DIR__ . "/__breadcrumb.php"; ?>

        <div class="fixed top-12 right-2 z-100" id="toast-container"></div>