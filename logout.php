<?php
session_start();
include 'config.php';

// Clear session
session_unset();
session_destroy();

// Clear cookies
if (isset($_COOKIE['user_id'])) {
    setcookie('user_id', '', time() - 3600, '/');
}
if (isset($_COOKIE['user_token'])) {
    setcookie('user_token', '', time() - 3600, '/');
}

// Redirect to home page after logout
header("Location: index.php");
exit;
?>
