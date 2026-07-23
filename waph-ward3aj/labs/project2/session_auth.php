<?php
// put at top of any page that needs a login to view

session_set_cookie_params([
    'lifetime' => 1800,
    'path' => '/',
    'domain' => '',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);

session_start();

if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    if (!isset($_SESSION['user_agent']) || $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
        $_SESSION = array();
        session_destroy();
        header("Location: index.php");
        exit();
    }
}
else {
    // if no sesseion then they dont get to see the page
    header("Location: index.php");
    exit();
}
