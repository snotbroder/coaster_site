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
    <header class="w-full p-4 max-h-4">
        <nav class="flex justify-between items-center">
            <a href="/"><img class="logo" src="../../static/assets/logo.svg" alt="Logo"></a>

            <!-- Desktop nav links -->
            <ul class="hidden md:flex flex-row gap-4 justify-between">
                <li><a href="/parks" class="head-link <?= $active == 'parks' ? 'header-link-active' : '' ?>">Parks</a></li>
                <li><a href="/coasters" class="head-link <?= $active == 'coasters' ? 'header-link-active' : '' ?>">Coasters</a></li>
                <li><a href="/map" class="head-link <?= $active == 'map' ? 'header-link-active' : '' ?>">Map</a></li>
            </ul>

            <!-- Desktop auth -->
            <ul class="hidden md:block">
                <li>
                    <?php if ($_SESSION["user_pk"] ?? false) : ?>
                        <a href="/profile">Profile</a>
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
                <li><a href="/parks" class="head-link block py-2 <?= $active == 'parks' ? 'header-link-active' : '' ?>">Parks</a></li>
                <li><a href="/coasters" class="head-link block py-2 <?= $active == 'coasters' ? 'header-link-active' : '' ?>">Coasters</a></li>
                <li><a href="/map" class="head-link block py-2 <?= $active == 'map' ? 'header-link-active' : '' ?>">Map</a></li>
            </ul>
            <div class="pt-3 pb-1 border-t border-(--darkened-eggshell)">
                <?php if ($_SESSION["user_pk"] ?? false) : ?>
                    <a href="/profile">Profile</a>
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
        document.addEventListener("DOMContentLoaded", function() {
            const burgerBtn = document.getElementById("burger-btn");
            const mobileMenu = document.getElementById("mobile-menu");
            const lines = burgerBtn.querySelectorAll(".burger-line");
            let isOpen = false;

            function setOpen(open) {
                isOpen = open;
                if (open) {
                    mobileMenu.classList.remove("hidden");
                } else {
                    mobileMenu.classList.add("hidden");
                }
                burgerBtn.setAttribute("aria-expanded", String(open));
                lines[0].style.transform = open ? "translateY(8px) rotate(45deg)" : "";
                lines[1].style.transform = open ? "scaleX(0)" : "";
                lines[1].style.opacity = open ? "0" : "";
                lines[2].style.transform = open ? "translateY(-8px) rotate(-45deg)" : "";
            }

            burgerBtn.addEventListener("click", function() {
                setOpen(!isOpen);
            });


            window.addEventListener("resize", function() {
                if (window.innerWidth >= 768 && isOpen) {
                    setOpen(false);
                }
            });
        });
    </script>
    <main>
        <?php require_once __DIR__ . "/__breadcrumb.php"; ?>

        <!-- <div class="absolute top-12 right-2" id="toast-container"></div> -->
        <?php require_once __DIR__ . "../../../config/_.php"; ?>