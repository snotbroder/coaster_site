<?php
session_start();
$_SESSION = [];
session_destroy();
?>
<div mix-redirect="/"></div>