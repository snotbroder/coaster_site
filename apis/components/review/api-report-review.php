<?php
try {
    require_once ROOT . "/config/_.php";
    $message = "Review reported. A moderator will decide if the review is against our guidelines.";
    // If everyting goes smooth, redirect to coaster page
?>
    <browser mix-update="#toast-container-header">
        <?php require_once ROOT . "/views/components/__toast_success.php" ?>
    </browser>

<?php
} catch (Exception $e) {
    http_response_code($e->getCode());
    $message = $e->getMessage();
    // Display error toast with message
?>
    <browser mix-update="#toast-container">
        <?php require_once ROOT . "/views/components/__toast_error.php" ?>
    </browser>
<?php
}
