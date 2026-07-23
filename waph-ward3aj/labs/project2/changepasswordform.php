<?php
require 'session_auth.php';

// need a token here too to rpevent people from changing passwords without knowing
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(16));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WAPH - Change Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Change Password</h1>

        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>

        <form method="POST" action="changepassword.php" class="form change-password" onsubmit="return checkPasswordsMatch();">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
            <!-- same password rules as the register page, gotta stay consistent -->
            <label>New Password:
                <input type="password" class="text_field" name="new_password" id="new_password"
                       required maxlength="50"
                       pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,50}"
                       title="At least 8 characters, with 1 uppercase, 1 lowercase, 1 number and 1 special character">
            </label>
            <label>Confirm New Password:
                <input type="password" class="text_field" name="confirm_password" id="confirm_password" required maxlength="50">
            </label>
            <p class="error" id="match-error" style="display:none;">Passwords do not match.</p>
            <button class="button" type="submit">Update Password</button>
        </form>

        <p><a href="profile.php">Back to profile</a></p>
    </div>

    <script>
        // same match check as registration
        function checkPasswordsMatch()
        {
            const password = document.getElementById('new_password').value;
            const confirm = document.getElementById('confirm_password').value;
            const errorEl = document.getElementById('match-error');
            if (password !== confirm) {
                errorEl.style.display = 'block';
                return false;
            }
            errorEl.style.display = 'none';
            return true;
        }
    </script>
</body>
</html>
