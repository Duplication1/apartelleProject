<?php
include_once("connection/connection.php");
$con = connection();
session_start();

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: homepage.php"); // Redirect to the home page
    exit();
}

// Check if user is already logged in
if (!isset($_SESSION['is_first_login'])) {
    header("Location: login.php"); // Redirect to the home page
    exit();
}

if (isset($_POST['submit'])) {
    $new_password = $_POST['pass'];

    $_SESSION['pass'] = $new_password; // Store password in session if you need it elsewhere

    // Password validation
    if (preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/", $new_password)) {
        $_SESSION['new_password'] = password_hash($new_password, PASSWORD_BCRYPT); // Hash password before storing
        header("Location: Firstenterinfo.php");
        exit();
    } else {
        $error_message = "Password does not meet the requirements.";
    }
}

// List of exception pages
$exceptions = ['Firstchangepass.php', 'firstenterinfo.php', 'firstenterpin.php'];
$current_page = basename($_SERVER['PHP_SELF']);

// Only include the alert script for pages not in $exceptions
if (!in_array($current_page, $exceptions)) {
    echo "<script>var triggerAlert = true;</script>";
} else {
    echo "<script>var triggerAlert = false;</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="css/Login.css"> 

</head>

<body>
    <div class="change-main change-main2">
        <div class="change-cont1">
            <img src="img/lock-img.png" alt="">
            <h1>Secure Your Account with a New Password</h1>
            <p>To ensure maximum security, please update the pre-made password. This step helps protect your account from unauthorized access, keeping your data safe at all times.</p>
        </div>

        <div class="change-cont2">
            <div class="progress-cont">
                <ul>
                    <li>
                        <a href="Firstchangepass.php" class="progress-unique">1</a>
                        <p class="progress-txt">Change Password</p>
                        <div></div>
                    </li>
                </ul>

                <ul>
                    <li>
                        <a>2</a>
                        <p>Personal Information</p>
                        <div></div>
                    </li>
                </ul>

                <ul>
                    <li>
                    <a>3</a>
                        <p>Set PIN Password</p>
                    </li>
                </ul>
            </div>
            
            <?php if (isset($error_message)) {
                echo "<p style='color:red;'>$error_message</p>";
            } ?>
            <form action="Firstchangepass.php" method="post">
                <div class="new-pass-cont">
                    <label>New Password</label>
                    <input type="password" name="pass" id="password" class="text-field" 
                           value="<?php echo isset($_SESSION['pass']) ? $_SESSION['pass'] : ''; ?>" required>
                    <span class="material-symbols-outlined eye-icon-change" id="eye-icon-change">visibility</span>
                </div>

                <div class="password-validation">
                    <ul class="validation-list">
                        <li>Password Requirements:</li>
                        <li id="length-check">At least 8 characters length</li>
                        <li id="uppercase-check">At least one uppercase letter (A-Z)</li>
                        <li id="lowercase-check">At least one lowercase letter (a-z)</li>
                        <li id="digit-check">At least one digit (0-9)</li>
                        <li id="special-check">At least one special character (!@#$%^&*)</li>
                    </ul>
                </div>

                <button type="submit" name="submit" class="change-pass-btn">Change Password<span class="material-symbols-outlined"> chevron_right </span></button>
            </form>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon-change');

        const lengthCheck = document.getElementById('length-check');
        const uppercaseCheck = document.getElementById('uppercase-check');
        const lowercaseCheck = document.getElementById('lowercase-check');
        const digitCheck = document.getElementById('digit-check');
        const specialCheck = document.getElementById('special-check');

        passwordInput.addEventListener('input', function() {
            const password = passwordInput.value;

            // Length check
            if (password.length >= 8) {
                lengthCheck.classList.add('valid');
            } else {
                lengthCheck.classList.remove('valid');
            }

            // Uppercase letter check
            if (/[A-Z]/.test(password)) {
                uppercaseCheck.classList.add('valid');
            } else {
                uppercaseCheck.classList.remove('valid');
            }

            // Lowercase letter check
            if (/[a-z]/.test(password)) {
                lowercaseCheck.classList.add('valid');
            } else {
                lowercaseCheck.classList.remove('valid');
            }

            // Digit check
            if (/\d/.test(password)) {
                digitCheck.classList.add('valid');
            } else {
                digitCheck.classList.remove('valid');
            }

            // Special character check
            if (/[\W_]/.test(password)) {
                specialCheck.classList.add('valid');
            } else {
                specialCheck.classList.remove('valid');
            }
        });


        // Show/Hide Password
        eyeIcon.addEventListener('click', function() {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.textContent = "visibility_off";
            } else {
                passwordInput.type = "password";
                eyeIcon.textContent = "visibility";
            }
        });

        // Function to show confirmation dialog when navigating away
        document.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function (event) {
                if (triggerAlert) {
                    event.preventDefault(); // Prevent immediate navigation
                    const userConfirmed = confirm("Are you sure? All fields will be cleared.");

                    if (userConfirmed) {
                        // If confirmed, unset the session variable and navigate
                        fetch('module/unset_session.php', { method: 'POST' }) // Call a PHP script to unset the session
                            .then(() => {
                                window.location.href = this.href;
                            });
                    }
                }
            });
        });


    </script>
</body>

</html>
