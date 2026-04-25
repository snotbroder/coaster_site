<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coaster Site | <?= $title ?? '' ?></title>
    <link href="/static/css/output.css" rel="stylesheet">
    <link href="/static/css/styles.css" rel="stylesheet">
    <link href="/static/css/globals.css" rel="stylesheet">
    <script src="/static/js/mixhtml.js" defer></script>
</head>

<body>
    <header class="w-full flex justify-between items-center p-4">
        <a href="/" class="<?= $active == 'index' ? '' : '' ?>">Home</a>
        <ul class="flex flex-row gap-4 justify-between">
            <li><a href="/parks" class="head-link <?= $active == 'parks' ? 'header-link-active' : '' ?>">Parks</a></li>
            <li><a href="/attractions" class="head-link <?= $active == 'attractions' ? 'header-link-active' : '' ?>">Attractions</a></li>
            <li><a href="/map" class="head-link <?= $active == 'map' ? 'header-link-active' : '' ?>">Map</a></li>
        </ul>
        <ul>
            <li>
                <?php if ($active !== 'login') : ?>
                    <a href="/login" class="<?= $active == 'login' ? '' : '' ?>">Login</a>
                <?php endif; ?>
            </li>
        </ul>
    </header>
    <div class="absolute top-12 left-2" id="toast-container">TOAST</div>

    <?php require_once __DIR__ . "../../../config/_.php"; ?>