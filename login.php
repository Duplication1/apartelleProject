<?php
session_start(); // Start the session

// Include the database connection
include 'connection/connection.php';

// Initialize error message variable
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT employee_id, pass, is_first_login, job FROM user_tbl WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if a user exists with the provided username
    if ($stmt->num_rows > 0) {
        // Bind the result variables
        $stmt->bind_result($employee_id, $stored_password, $is_first_login, $job);
        $stmt->fetch();

        // Verify the password
        if ($password === $stored_password) {
            // Check if the user is an Admin
            if ($job == 'Admin') {
                // Insert a new time log into the admin_time_logs table
                $log_stmt = $conn->prepare("INSERT INTO admin_time_logs (admin_id) VALUES (?)");
                $log_stmt->bind_param("i", $employee_id);
                $log_stmt->execute();
                $log_stmt->close();
                
                // Check if it's the first login
                if ($is_first_login == 1) {
                    $_SESSION['employee_id'] = $employee_id; // store user ID in session
                    header("Location: dashboard.php");
                    exit();
                } else {
                    // Set session variables for the logged-in user
                    $_SESSION['employee_id'] = $employee_id;
                    $_SESSION['username'] = $username;

                    // Redirect to a welcome page or dashboard
                    header("Location: dashboard.php");
                    exit();
                }
            } else {
                // If the user is not an admin, handle accordingly (optional)
                $error = "You do not have admin privileges.";
            }
        } else {
            $error = "Invalid password."; // Password does not match
        }
    } else {
        $error = "No user found with that username."; // Username not found
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Login Form -->
    <form class="login-form" method="POST" action="">
        <img src="images/apartelle-logo.png" class="login-logo">
        <h1 class="sign-in-label">Sign in</h1>

        <!-- Display error message if login fails -->
        <?php if ($error): ?>
            <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        
        <label for="username" class="login-label">Username</label>
        <input type="text" id="username" name="username" class="login-input-username" required />

        <label for="password" class="login-label">Password</label>
        <div class="password-container">
            <input type="password" id="password" name="password" class="login-input-password" required />
            <img id="togglePassword" class="eye-icon" src="images/closed_eye.png" alt="Toggle Password Visibility">
        </div>

        <p class="forgot-password">Forgot password?</p>
        <button class="login-button" type="submit">Sign in</button>
    </form>

    <!-- JavaScript for password visibility toggle -->
    <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.src = type === 'password' ? 'images/closed_eye.png' : 'images/remove_red_eye.png'; 
    });
    </script>
</body>
</html>
