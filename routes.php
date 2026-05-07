<?php

require_once __DIR__ . '/router.php';
define('ROOT', __DIR__);

// Views
get('/', 'views/page-index.php');
get('/map', 'views/page-map.php');
get('/parks', 'views/page-parks.php');
get('/coasters', 'views/page-coasters.php');
get('/login', 'views/page-login.php');
get('/sign-up', 'views/page-sign-up.php');
get('/404', 'views/page-404.php');

// Apis
post('/api-login', 'apis/api-login.php');
post('/api-sign-up', 'apis/api-sign-up.php');


// Test routes
get('/items/$category', 'pages/page-items.php');
get('/items/$category/size/$size', 'pages/page-items.php');
