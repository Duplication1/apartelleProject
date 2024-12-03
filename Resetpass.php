<?php
include_once("connection/connection.php");
$con = connection();
session_start();


if (isset($_POST['submit'])) {
    $new_password = $_POST['new_password'];

    // Server-side validation (in case JS is bypassed)
    if (preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/", $new_password)) {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password in the database
            $sql = "UPDATE manager_tbl SET pass = '$hashed_password' WHERE job = 'om'";
            $con->query($sql) or die($con->error);

            // Clear session
            session_unset();
            session_destroy();

            header("Location: homepage.php");
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
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="css/login.css">

    <style>
        .reset-main {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-reset {
            max-width: 450px;
            padding: 8px;
            background-color: var(--white-plain);
            filter: drop-shadow(0px 0px 32px rgba(0, 0, 0, 0.1));
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 36px;
        }

        .card-reset-form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            filter: drop-shadow(0px 0px 32px rgba(0, 0, 0, 0.1));
        }

        .reset-field {
            margin-top: 10px;
            border-radius: 4px;
            border: 1px solid var(--text-field);
            width: 100%;
            height: 43px;
            padding: 8px;
            font-size: var(--sm-font);
            transition: border-color 0.3s;
        }

        .reset-btn {
            float: right;
            border-radius: 999px;
            border: none;
            color: var(--white-plain);
            font-size: var(--sm-font);
            cursor: pointer;
            font-weight: 600;
            background-color: var(--blue-btn);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            font-size: var(--md-font);
            margin-top: 24px;
            padding: 12px 32px;
        }

        .reset-btn span {
            margin-left: 10px;
        }

        .reset-btn:hover {
            background-color: var(--hover-blue);
        }

        .logo {
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>

    <div class="reset-main">
        <div class="card-reset">
            <?php if (isset($error_message)) {
                echo "<p style='color:red;'>$error_message</p>";
            } ?>

            <form action="Resetpass.php" method="post">
                <img src="img/nav-logo-no-text.png" alt="apartelle logo" class="logo">

                <h1>New Password</h1>

                <p class="regular-text">Please reset your password based on the requirements below.</p>
                <input type="password" name="new_password" id="password-input" class="reset-field" required>

                <div class="password-validation">
                    <ul class="validation-list">
                        <li id="length-check">At least 8 characters length</li>
                        <li id="uppercase-check">At least one uppercase letter (A-Z)</li>
                        <li id="lowercase-check">At least one lowercase letter (a-z)</li>
                        <li id="digit-check">At least one digit (0-9)</li>
                        <li id="special-check">At least one special character (!@#$%^&*)</li>
                    </ul>
                </div>

                <span class="error" id="password-error"></span>
                <button type="submit" name="submit" class="reset-btn">Reset Password</button>
            </form>
        </div>
    </div>


    <script>
        const passwordInput = document.getElementById('password-input');

        const lengthCheck = document.getElementById('length-check');
        const uppercaseCheck = document.getElementById('uppercase-check');
        const lowercaseCheck = document.getElementById('lowercase-check');
        const digitCheck = document.getElementById('digit-check');
        const specialCheck = document.getElementById('special-check');

        passwordInput.addEventListener('input', function() {
            const password = passwordInput.value;

            // Check for at least 8 characters
            if (password.length >= 8) {
                lengthCheck.innerHTML = '✔️ At least 8 characters length';
            } else {
                lengthCheck.innerHTML = '<i class="fa-solid fa-circle dot"></i> At least 8 characters length';
            }

            // Check for at least one uppercase letter
            if (/[A-Z]/.test(password)) {
                uppercaseCheck.innerHTML = '✔️ At least one uppercase letter (A-Z)';
            } else {
                uppercaseCheck.innerHTML = '<i class="fa-solid fa-circle dot"></i> At least one uppercase letter (A-Z)';
            }

            // Check for at least one lowercase letter
            if (/[a-z]/.test(password)) {
                lowercaseCheck.innerHTML = '✔️ At least one lowercase letter (a-z)';
            } else {
                lowercaseCheck.innerHTML = '<i class="fa-solid fa-circle dot"></i> At least one lowercase letter (a-z)';
            }

            // Check for at least one digit
            if (/\d/.test(password)) {
                digitCheck.innerHTML = '✔️ At least one digit (0-9)';
            } else {
                digitCheck.innerHTML = '<i class="fa-solid fa-circle dot"></i> At least one digit (0-9)';
            }

            // Check for at least one special character
            if (/[\W_]/.test(password)) {
                specialCheck.innerHTML = '✔️ At least one special character (!@#$%^&*)';
            } else {
                specialCheck.innerHTML = '<i class="fa-solid fa-circle dot"></i> At least one special character (!@#$%^&*)';
            }
        });
    </script>

</body>

</html>