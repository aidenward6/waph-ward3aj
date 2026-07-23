<?php
require 'session_auth.php';

$username = $_SESSION['username'];
$csrfToken = $_POST['csrf_token'] ?? '';

// checking the token before touching the password at all
if (!hash_equals($_SESSION['csrf_token'] ?? '', $csrfToken)) {
    header("Location: changepasswordform.php?error=" . urlencode('Invalid or expired form submission. Please try again.'));
    exit();
}

$newPassword = $_POST['new_password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// same rules as registration so its consistent everywhere
if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,50}$/', $newPassword)) {
    header("Location: changepasswordform.php?error=" . urlencode('Password must be 8-50 characters, with at least 1 uppercase letter, 1 lowercase letter, 1 number and 1 special character.'));
    exit();
}

if ($newPassword !== $confirm_password) {
    header("Location: changepasswordform.php?error=" . urlencode('Passwords do not match.'));
    exit();
}

require 'db_connect.php';

// bcrypt hash, never ever store the plain password
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

$stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE username = ?");
$stmt->bind_param("ss", $hashedPassword, $username);
$stmt->execute();
$stmt->close();
$mysqli->close();

header("Location: profile.php?password_changed=1");
exit();
