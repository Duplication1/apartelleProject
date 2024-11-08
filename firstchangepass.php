<?php
include_once("connection/connection.php");

session_start();

if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $new_password = $_POST['pass'];
    // Password validation
    if (preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/", $new_password)) {
        $_SESSION['new_password'] = password_hash($new_password, PASSWORD_BCRYPT);
        header("Location: firstenterinfo.php");
        exit();
    } else {
        $error_message = "Password does not meet the requirements.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="css/firstchangepass.css">
</head>
<body>
<body>  
    <h1>Step 1: Change Password</h1>
    <?php if (isset($error_message)) { echo "<p style='color:red;'>$error_message</p>"; } ?>
    <form action="firstchangepass.php" method="post">
        <label>New Password</label>
        <input type="password" name="pass" id="password-input" required>
        <div class="password-validation">
            <div>
                <ul class="validation-list">
                    <div>
                        <li id="length-check"><i class="fa-solid fa-circle dot"></i> At least 8 characters length</li>
                        <li id="uppercase-check"><i class="fa-solid fa-circle dot"></i> At least one uppercase letter (A-Z)</li>
                        <li id="lowercase-check"><i class="fa-solid fa-circle dot"></i> At least one lowercase letter (a-z)</li>
                    </div>

                    <div>
                        <li id="digit-check"><i class="fa-solid fa-circle dot"></i> At least one digit (0-9)</li>
                        <li id="special-check"><i class="fa-solid fa-circle dot"></i> At least one special character (!@#$%^&*)</li>
                    </div>
                </ul>
            </div>
        </div>

        <span class="error" id="password-error"></span>
        <button type="submit" name="submit">Change Password</button>
    </form>

    <script>
        const passwordInput = document.getElementById('password-input');

        const lengthCheck = document.getElementById('length-check');
        const uppercaseCheck = document.getElementById('uppercase-check');
        const lowercaseCheck = document.getElementById('lowercase-check');
        const digitCheck = document.getElementById('digit-check');
        const specialCheck = document.getElementById('special-check');

        passwordInput.addEventListener('input', function () {
            const password = passwordInput.value;

            // This is to check if the entered password is at least 8 characters
            if (password.length >= 8) {
                lengthCheck.innerHTML = '✔️ At least 8 characters length';
            } else {
                lengthCheck.innerHTML = '<i class="fa-solid fa-circle dot"></i> At least 8 characters length';
            }

            // Verifies if the entered password has at least one uppercase letter

            if (/[A-Z]/.test(password)) {
                uppercaseCheck.innerHTML = '✔️ At least one uppercase letter (A-Z)';
            } else {
                uppercaseCheck.innerHTML = '<i class="fa-solid fa-circle dot"></i> At least one uppercase letter (A-Z)';
            }

            // Verifies if the entered password has at least one lowercase letter
            if (/[a-z]/.test(password)) {
                lowercaseCheck.innerHTML = '✔️ At least one lowercase letter (a-z)';
            } else {
                lowercaseCheck.innerHTML = '<i class="fa-solid fa-circle dot"></i> At least one lowercase letter (a-z)';
            }

            // Verifies if the entered password has at least one digit
            if (/\d/.test(password)) {
                digitCheck.innerHTML = '✔️ At least one digit (0-9)';
            } else {
                digitCheck.innerHTML = '<i class="fa-solid fa-circle dot"></i> At least one digit (0-9)';
            }

            // Verifies if the entered password has at least one special character
            if (/[\W_]/.test(password)) {
                specialCheck.innerHTML = '✔️ At least one special character (!@#$%^&*)';
            } else {
                specialCheck.innerHTML = '<i class="fa-solid fa-circle dot"></i> At least one special character (!@#$%^&*)';
            }
        });
    </script>

</body>
</html>

