<?php
include_once("connection/connection.php");
$con = connection();
session_start();

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Initialize alert variables
$alert_message = '';
$alert_color = '';

// Ensure session variables are set
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}
if (!isset($_SESSION['lock_time'])) {
    $_SESSION['lock_time'] = null;
}
if (!isset($_SESSION['indefinite_lock'])) {
    $_SESSION['indefinite_lock'] = false;
}

// Handle indefinite lock
if ($_SESSION['indefinite_lock'] && !isset($_SESSION['user_id'])) {
    $alert_message = "Account locked indefinitely. Please continue with Email.";
    $alert_color = "red";
} elseif ($_SESSION['lock_time'] && time() < $_SESSION['lock_time']) {
    $remaining_time = $_SESSION['lock_time'] - time();
    $remaining_minutes = ceil($remaining_time / 60); // Convert seconds to minutes
    $alert_message = "Too many failed attempts. Please try again in $remaining_minutes minute(s).";
    $alert_color = "red";
} elseif ($_SESSION['lock_time'] && time() >= $_SESSION['lock_time']) {
    // Reset lock time and attempts after timeout
    $_SESSION['lock_time'] = null;
}

// Handle login attempts
if (isset($_POST['submit']) && !$alert_message) {
    $username = $_POST['username'];
    $job = "om";
    $password = $_POST['pass'];

    // Fetch user data with the provided username
    $sql = "SELECT * FROM manager_tbl WHERE username = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Check for correct job
        if ($row['job'] !== $job) {
            // Incorrect job value
            $_SESSION['login_attempts']++;
            $alert_message = "You have are not authorized to access this system.";
            $alert_color = "red"; // Different color for job-related errors
        } else {
            // Verify password
            if (password_verify($password, $row['pass'])) {
                
                if ($row['is_first_login'] == 1) {
                    $_SESSION['is_first_login'] = true;
                    header("Location: FirstChangePass.php");
                } else {
                    $_SESSION['user_id'] = $row['employee_id'];
                    header("Location: homepage.php");
                }
                // Reset attempts upon successful login
                $_SESSION['login_attempts'] = 0;
                exit();
            } else {
                // Incorrect password
                $_SESSION['login_attempts']++;
                $alert_message = "Invalid username or password.";
                $alert_color = "red";
            }
        }
    } else {
        // Invalid username
        $_SESSION['login_attempts']++;
        $alert_message = "Invalid username or password.";
        $alert_color = "red";
    }

    // Lockout logic
    if ($_SESSION['login_attempts'] == 9) {
        // Indefinite lock after 10th failed attempt
        $_SESSION['indefinite_lock'] = true;
    } elseif ($_SESSION['login_attempts'] == 4) {
        // Lock for 15 minutes after 5th failed attempt
        $_SESSION['lock_time'] = time() + (15 * 60); // 15 minutes in seconds
    }
}
// Unset the session after redirection unless on the exception pages
$exceptions = ['FirstChangePass.php', 'FirstEnterInfo.php', 'FirstEnterPin.php'];
$current_page = basename($_SERVER['PHP_SELF']);
if (!in_array($current_page, $exceptions) && isset($_SESSION['is_first_login'])) {
    unset($_SESSION['firstname'], $_SESSION['middlename'], $_SESSION['lastname'], $_SESSION['birthdate'], $_SESSION['email'], $_SESSION['phone'], $_SESSION['address'], $_SESSION['gender'], $_SESSION['pass'], $_SESSION['pin1'], $_SESSION['pin2'], $_SESSION['pin3'], $_SESSION['pin4'], $_SESSION['pin5'], $_SESSION['pin6'], $_SESSION['confirm-pin1'], $_SESSION['confirm-pin2'], $_SESSION['confirm-pin3'], $_SESSION['confirm-pin4'], $_SESSION['confirm-pin5'], $_SESSION['confirm-pin6'], $_SESSION['house_no'], $_SESSION['street_name'], $_SESSION['barangay_name'], $_SESSION['city'], $_SESSION['province'], $_SESSION['zip_code'], $_SESSION['is_first_login']);
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Information Registration</title>
    <link rel="stylesheet" href="css/Login.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>
<body>
    <div class="login-main" id="login">
        <div class="card">
            <div class="login-header">
                <img src="img/nav-logo-no-text.png" alt="apartelle logo" class="logo">
                <h1>Sign in to your account</h1>
            </div>

            <!-- Alert message paragraph -->
            <?php if (!empty($alert_message)): ?>
                <p id="alertMessage" style="color: <?= $alert_color ?>;"><?= $alert_message ?></p>
            <?php endif; ?>

            <form action="" method="post">
                <div class="pass-parent">
                    <label>Username</label>
                    <input type="text" name="username" class="text-field" required>

                    <label>Password</label>
                    <input type="password" name="pass" id="password" class="text-field" required>
                    <span class="material-symbols-outlined eye-icon">visibility</span>
                </div>

                <div class="forgot-parent">
                    <a href="Forgotpass.php" class="forgot-txt">Forgot password?</a>
                    <button type="submit" name="submit" class="login-submit">Sign in</button>

                    <div class="hr-or">
                        <hr>
                        <p class="or">OR</p>
                    </div>
                    <a href="EmailLogin.php" class="login-submit-border email-parent">
                        <span class="material-symbols-outlined email">mail</span>Continue with Email
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
<script src="js/Login.js"></script>
</html>
