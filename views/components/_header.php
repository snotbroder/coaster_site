<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coaster Site | <?= $title ?? '' ?></title>
    <link href="../../static/css/output.css" rel="stylesheet">
    <link href="../../static/css/styles.css" rel="stylesheet">
</head>
<body>
    <header class="w-full h-16 bg-gray-800 text-white flex flex-row items-center justify-between px-4">
        <ul class="flex flex-row gap-2 justify-between">
            <li><a href="/" class="<?= $active == 'index' ? 'text-red-400' : '' ?>">Home</a></li>
            <li><a href="/map" class="<?= $active == 'map' ? 'text-red-400' : '' ?>">Map</a></li>
        </ul>
        <ul><li><a href="/login" class="<?= $active == 'login' ? 'text-red-400' : '' ?>">Login</a></li></ul>
    </header>
    
    <?php require_once __DIR__."../../../config/_.php"; ?>