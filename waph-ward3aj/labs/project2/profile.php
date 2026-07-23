<?php
require 'session_auth.php';
require 'db_connect.php';

$username = $_SESSION['username'];
$errors = [];
$success = isset($_GET['password_changed']) ? 'Password updated successfully.' : "";

// make a csrf token if we dont got one yet
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(16));
}

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';


    if (!hash_equals($_SESSION['csrf_token'], $csrfToken)) {
        $errors[] = 'Invalid or expired form submission. Please try again.';
    } else {
        $name = htmlspecialchars(trim(stripslashes($_POST['name'] ?? '')), ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars(trim(stripslashes($_POST['email'] ?? '')), ENT_QUOTES, 'UTF-8');

        if ($name === '' || strlen($name) > 100) {
            $errors[] = 'Name is required and must be 100 characters or fewer.';
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false || strlen($email) > 100) {
            $errors[] = 'A valid email address is required.';
        }

        // only touching name and email here, nothing else changes
        if (empty($errors)) {
            $stmt = $mysqli->prepare("UPDATE users SET name = ?, email = ? WHERE username = ?");
            $stmt->bind_param("sss", $name, $email, $username);
            $stmt->execute();
            $stmt->close();
            $success = 'Profile updated successfully.';
        }
    }
}

$stmt = $mysqli->prepare("SELECT name, email FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($name, $email);
$stmt->fetch();
$stmt->close();
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WAPH - Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <img class="headshot-small" src="headshot.jpeg" alt="Headshot">
        <h1>Welcome, <?php echo htmlentities($username, ENT_QUOTES, 'UTF-8'); ?></h1>

        <?php if (!empty($errors)): ?>
            <ul class="error">
                <?php foreach ($errors as $err): ?>
                    <li><?php echo htmlspecialchars($err, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <?php if ($success !== ''): ?>
            <p class="success"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>

        <form method="POST" action="profile.php" class="form profile">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
            <label>Name:
                <input type="text" class="text_field" name="name" required maxlength="100"
                       value="<?php echo htmlentities($name, ENT_QUOTES, 'UTF-8'); ?>">
            </label>
            <label>Email:
                <input type="email" class="text_field" name="email" required maxlength="100"
                       value="<?php echo htmlentities($email, ENT_QUOTES, 'UTF-8'); ?>">
            </label>
            <button class="button" type="submit">Save Changes</button>
        </form>

        <p><a href="changepasswordform.php">Change Password</a> | <a href="logout.php">Logout</a></p>
    </div>
</body>
</html>
