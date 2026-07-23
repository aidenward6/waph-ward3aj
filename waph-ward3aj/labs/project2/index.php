<?php
// cookie setup
session_set_cookie_params([
    'lifetime' => 1800,
    'path' => '/',
    'domain' => '',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);

session_start();

if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true)
{
    header("Location: profile.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'db_connect.php';

    $username = trim(stripslashes($_POST['username'] ?? ''));
    $password = $_POST['password'] ?? '';

    // double check, though html already checks it
    if (!preg_match('/^[a-zA-Z0-9_]{3,50}$/', $username) || $password === '') {
        $error = 'Invalid username or password.';
    } else {
        $stmt = $mysqli->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($hashed_password);

        if ($stmt->fetch() && password_verify($password, $hashed_password)) {
            $stmt->close();
            // new session id every login, learned this from lab4 hijac
            session_regenerate_id(true);
            $_SESSION['authenticated'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            header("Location: profile.php");
            exit();
        } else {
            $stmt->close();
            $error = 'Invalid username or password.';
        }
    }
    $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WAPH - Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>WAPH Project 2 - Login</h1>

        <?php if ($error !== ''): ?>
            <p class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        <?php if (isset($_GET['registered'])): ?>
            <p class="success">Registration successful. Please log in.</p>
        <?php endif; ?>

        <form method="POST" action="index.php" class="form login">
            <label>Username:
                <input type="text" class="text_field" name="username"
                       required maxlength="50" pattern="[a-zA-Z0-9_]{3,50}"
                       title="3-50 characters: letters, numbers, underscore only">
            </label>
            <label>Password:
                <input type="password" class="text_field" name="password" required>
            </label>
            <button class="button" type="submit">Login</button>
        </form>

        <p>Don't have an account? <a href="registrationform.php">Register here</a>.</p>
    </div>
</body>
</html>
