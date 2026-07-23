<?php
require 'db_connect.php';

// just some regex checks
function isValidUsername($username) {
    return preg_match('/^[a-zA-Z0-9_]{3,50}$/', $username) === 1;
}

function isValidPassword($password) {
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,50}$/', $password) === 1;
}

function isValidEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false && strlen($email) <= 100;
}

$errors = array();

// cleaning up everything before it touches the page or the db
$username = htmlspecialchars(trim(stripslashes($_POST['username'] ?? '')), ENT_QUOTES, 'UTF-8');
$name = htmlspecialchars(trim(stripslashes($_POST['name'] ?? '')), ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars(trim(stripslashes($_POST['email'] ?? '')), ENT_QUOTES, 'UTF-8');
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

// Re-validate server-side
if (!isValidUsername($username)) {
    $errors[] = 'Username must be 3-50 characters: letters, numbers, underscore only.';
}
if ($name === '' || strlen($name) > 100) {
    $errors[] = 'Name is required and must be 100 characters or fewer.';
}
if (!isValidEmail($email)) {
    $errors[] = 'A valid email address is required.';
}
if (!isValidPassword($password)) {
    $errors[] = 'Password must be 8-50 characters, with at least 1 uppercase letter, 1 lowercase letter, 1 number and 1 special character.';
}
if ($password !== $confirmPassword) {
    $errors[] = 'Passwords do not match.';
}

// checkif someone  already took this username before we insert
if (empty($errors)) {
    $stmt = $mysqli->prepare("SELECT username FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $errors[] = 'That username is already taken. Please choose another.';
    }
    $stmt->close();
}

if (empty($errors)) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("INSERT INTO users (username, password, name, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $hashedPassword, $name, $email);

    if ($stmt->execute()) {
        $stmt->close();
        $mysqli->close();
        header("Location: index.php?registered=1");
        exit();
    } else {
        $errors[] = 'Registration failed. Please try again.';
    }
    $stmt->close();
}

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WAPH - Registration Error</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Registration Failed</h1>
        <ul class="error">
            <?php foreach ($errors as $err): ?>
                <li><?php echo htmlspecialchars($err, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
        <p><a href="registrationform.php">Back to registration form</a>.</p>
    </div>
</body>
</html>
