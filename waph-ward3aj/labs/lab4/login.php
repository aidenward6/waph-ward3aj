<?php
session_start();

if ($password_is_correct) {
    session_regenerate_id(true);
    $_SESSION['username'] = $username;
    
    header("Location: index.php");
    exit();
}
?>
