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

    <!-- LEaflet map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
    <script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
</head>
<?php require_once ROOT . "/config/_.php"; ?>

<body>
    <header class="w-full shadow-md bg-(--darkened-eggshell)">
        <nav class="flex justify-between flex-wrap items-center">
            <div class="flex gap-2 items-center">
                <a href="/"><img class="logo" src="../../static/assets/logo.svg" alt="Logo"></a>
                <h3 class="text-(--light-indigo)!">System panel</h3>
            </div>
            <!-- Desktop nav links -->
            <ul class="hidden md:flex flex-row gap-1 justify-between md:col-2 lg:col-3">
                <!-- <li><a href="/parks" class="head-link <?= $active == 'parks' ? 'header-link-active' : '' ?>">Parks</a></li>
                <li><a href="/coasters" class="head-link <?= $active == 'coasters' ? 'header-link-active' : '' ?>">Coasters</a></li>
                <li><a href="/map" class="head-link <?= $active == 'map' ? 'header-link-active' : '' ?>">Map</a></li> -->
            </ul>

            <!-- Desktop auth -->
            <ul class="flex md:justify-end md:col-3 lg:col-5">
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

                                <div class="border-b border-(--darkened-eggshell) py-4 w-full">
                                    <a class="btn-primary small w-full!" href="/">Back to site</a>
                                </div>
                                <a href="/contact" class="hyperlink">Add parks</a>
                                <a href="/my-reviews" class="hyperlink">Add coasters</a>
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

        </nav>

    </header>
    <main>