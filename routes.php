<?php

require_once __DIR__.'/router.php';

get('/', 'views/page-index.php');
get('/map', 'views/page-map.php');
get('/404', 'views/page-404.php');


get('/items/$category', 'pages/page-items.php');

get('/items/$category/size/$size', 'pages/page-items.php');