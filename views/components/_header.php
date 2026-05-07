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

<body>
    <header class="w-full  p-4 max-h-4 ">
        <nav class="flex justify-between items-center">
            <a href="/"><img class="logo" src="../../static/assets/logo.svg" alt="Logo"></a>
            <ul class="flex flex-row gap-4 justify-between">
                <li><a href="/parks" class="head-link <?= $active == 'parks' ? 'header-link-active' : '' ?>">Parks</a></li>
                <li><a href="/coasters" class="head-link <?= $active == 'coasters' ? 'header-link-active' : '' ?>">Coasters</a></li>
                <li><a href="/map" class="head-link <?= $active == 'map' ? 'header-link-active' : '' ?>">Map</a></li>
            </ul>
            <ul>
                <li>
                    <?php if ($_SESSION['user_pk'] ?? false) : ?>
                        <a href="/profile" class="<?= $active == 'profile' ? '' : '' ?>">Profile</a>
                    <?php else : ?>
                        <?php if ($active == 'login') : ?>
                            <a href="/sign-up" class="btn-primary <?= $active == 'sign-up' ? '' : '' ?>">Sign Up</a>
                        <?php endif; ?>
                        <?php if ($active !== 'login') : ?>
                            <a href="/login" class="btn-primary <?= $active == 'login' ? '' : '' ?>">Login</a>

                        <?php endif; ?>

                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <?php require_once __DIR__ . "/__breadcrumb.php"; ?>

        <!-- <div class="absolute top-12 right-2" id="toast-container"></div> -->
        <?php require_once __DIR__ . "../../../config/_.php"; ?>