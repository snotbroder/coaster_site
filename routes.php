<?php

require_once __DIR__ . '/router.php';

// Views
get('/', 'views/page-index.php');
get('/map', 'views/page-map.php');
get('/parks', 'views/page-parks.php');
get('/attractions', 'views/page-attractions.php');
get('/login', 'views/page-login.php');
get('/sign-up', 'views/page-sign-up.php');
get('/404', 'views/page-404.php');

// Apis
post('/api-login', 'apis/api-login.php');
post('/api-sign-up', 'apis/api-sign-up.php');


// Test routes
get('/items/$category', 'pages/page-items.php');
get('/items/$category/size/$size', 'pages/page-items.php');
