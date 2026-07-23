<?php
// using the non root user from lab 3, dont wanna give the app full db access
$mysqli = new mysqli('localhost', 'ward3aj', 'Password123', 'waph');

if ($mysqli->connect_errno) {
    die("Database connection failed: " . $mysqli->connect_error);
}
