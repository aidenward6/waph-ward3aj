<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WAPH - Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>WAPH Project 2 - Register</h1>

        <!-- reused the css from project 1, form checks passwords match before sending -->
        <form method="POST" action="addnewuser.php" class="form registration" onsubmit="return checkPasswordsMatch();">
            <label>Username:
                <input type="text" class="text_field" name="username" id="username"
                       required maxlength="50" pattern="[a-zA-Z0-9_]{3,50}"
                       title="3-50 characters: letters, numbers, underscore only">
            </label>
            <label>Name:
              <input type="text" class="text_field" name="name" id="name"
                  required maxlength="100">
            </label>
            <label>Email:
                <input type="email" class="text_field" name="email" id="email"
                       required maxlength="100">
            </label>
            <!-- gotta have upper lower number and a symbol or it wont let u submit -->
            <label>Password:
                <input type="password" class="text_field" name="password" id="password"
                       required maxlength="50"
                       pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,50}"
                       title="At least 8 characters, with 1 uppercase, 1 lowercase, 1 number and 1 special character">
            </label>
            <label>Confirm Password:
                <input type="password" class="text_field" name="confirm_password" id="confirm_password"
                       required maxlength="50">
            </label>
            <p class="error" id="match-error" style="display:none;">Passwords do not match.</p>
            <button class="button" type="submit">Register</button>
        </form>

        <p>Already have an account? <a href="index.php">Login here</a>.</p>
    </div>

    <script>
        
        function checkPasswordsMatch() {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('confirm_password').value;
            const errorEl = document.getElementById("match-error");
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
