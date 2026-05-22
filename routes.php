<?php

require_once __DIR__ . '/router.php';
define('ROOT', __DIR__);

//always check if session is alive
session_start();
// Views
get('/', 'views/page-index.php');
get('/map', 'views/page-map.php');
get('/parks', 'views/page-parks.php');
get('/coasters', 'views/page-coasters.php');
get('/login', 'views/page-login.php');
get('/sign-up', 'views/page-sign-up.php');
get('/account', 'views/page-account.php');

// Admin views
get('/admin/configure-coasters', 'views/page-admin-configure-coasters.php');
get('/admin/configure-parks', 'views/page-admin-configure-parks.php');

// Apis
post('/api-login', 'apis/api-login.php');
post('/api-logout', 'apis/api-logout.php');
post('/api-sign-up', 'apis/api-sign-up.php');
post('/api-index-search-coaster', 'apis/components/api-index-search-coaster.php');
post('/api-search-coaster', 'apis/components/api-search-coaster');
post('/api-search-park', 'apis/api-search-park.php');
post('/api-get-park-coasters', 'apis/api-get-park-coasters.php');
post('/api-filter-parks', 'apis/api-filter-parks.php');

// Review apis
post('/api-create-review', 'apis/components/review/api-create-review.php');
post('/api-delete-review', 'apis/components/review/api-delete-review.php');
post('/api-request-delete-review', 'apis/components/review/api-request-delete-review.php');

// Account apis
post('/api-request-update-avatar', 'apis/components/account/api-request-update-avatar.php');


// Admin apis
post('/api-add-coaster', 'apis/admin/api-add-coaster.php');
post('/api-add-park', 'apis/admin/api-add-park.php');

// Pagination apis
get('/api-pagination-coasters', 'apis/components/api-pagination-coasters.php');
get('/api-pagination-parks', 'apis/components/api-pagination-parks.php');

// Fallback route - must be last, acts as catch-all for unmatched GET routes
get('/404', 'views/page-404.php');

// Test routes
get('/items/$category', 'pages/page-items.php');
get('/items/$category/size/$size', 'pages/page-items.php');
