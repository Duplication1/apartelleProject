<?php 

include_once("connection/connection.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

session_start();
$con = connection();

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: homepage.php"); 
    exit();
}

// Fetch the email
$sql = "SELECT email FROM manager_tbl WHERE job = 'om' LIMIT 1";
$result = $con->query($sql);

// Initialize a variable to track the result
$email_label = null;
$job_error = false; // Flag to track if the job value is wrong

if ($result) {
    if ($row = $result->fetch_assoc()) {
        // Email found 
        $email_label = $row['email'];
    } else {
        // No email found, set the flag
        $email_label = null;
    }
} else {
    // If the query fails due to a database error, set job_error to true
    $job_error = true;
}

// Function to send a reset code via email
function sendResetCode($email_label) {
    unset($_SESSION['login_code']);
    
    $login_code = rand(100000, 999999);
    $_SESSION['login_code'] = $login_code; 

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'novastarapartelle@gmail.com';
        $mail->Password = 'ipjx rbaz njzz udgc';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('novastarapartelle@gmail.com', 'Novastar Apartelle');
        $mail->addAddress($email_label);
        $mail->isHTML(true);
        $mail->Subject = 'Password Login Code';
        $mail->Body = "Your Login code is: <strong>$login_code</strong>";

        $mail->send();
        return ["success" => true, "message" => "Login code sent to $email_label", "code" => $login_code];
    } catch (Exception $e) {
        return ["success" => false, "message" => "Error: {$mail->ErrorInfo}"];
    }
}

// Handle sending the reset code
if (isset($_POST['send_code'])) {
    if ($email_label === null) {
        $alert_message = "No email found"; // Display if no email is found
    } elseif ($job_error) {
        $alert_message = "Error: Invalid job value or database error"; // Display if job value is incorrect or there's a database issue
    } else {
        $response = sendResetCode($email_label);
        $alert_message = $response['message'];
        $code_sent = true;
    }
}

// Check for AJAX request to resend the code
if (isset($_POST['action']) && $_POST['action'] == 'resend_code') {
    if ($email_label === null) {
        echo json_encode(["success" => false, "message" => "No email found"]);
    } elseif ($job_error) {
        echo json_encode(["success" => false, "message" => "You have are not authorized to access this system"]);
    } else {
        $response = sendResetCode($email_label);
        echo json_encode($response);
    }
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Email</title>
    <link rel="stylesheet" href="css/Login.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <style>
        .resend-btn {
            background-color: transparent;
            border: none;
            float: right;
            margin: 24px 0;
            border-radius: 999px;
            color: var(--text-field);
            font-size: var(--sm-font);
            cursor: pointer;
            font-weight: 600;
            font-size: var(--md-font);
            padding: 12px 36px;
            display: flex;
            position: relative;
        }

        .forgot-btn {
            background-color: transparent;
        }

        .resend-btn:hover {
            background-color: #F0F0F0;
        }

        .resend-btn span {
            padding: 0;
            font-size: 24px;
            /* background-color: red; */
            margin-right: 16px;
            /* text-align: center; */
            position: absolute;
            left: 8px;
            top: 8px;
        }
    </style>
</head>

<body>

    <div class="forgot-main">
        <div class="card-forgot">

            <form method="post">
                <img src="img/nav-logo-no-text.png" alt="apartelle logo" class="logo">
                <h1>Signin using email</h1>

                <p class="mid-txt"><?php echo htmlspecialchars($email_label); ?></p>

                <!-- Regular text paragraph -->
                <p class="regular-txt" id="regularText">
                    We will send the code to <?php echo htmlspecialchars($email_label); ?>. Click “Send Code” to continue the process.
                </p>

                <!-- Alert message paragraph -->
                <p id="alertMessage"><?php echo isset($alert_message) ? "<span style='color: green;'>$alert_message</span>" : ''; ?></p>

                <div>
                    <label class="lb">Enter the code</label>
                    <input type="text " name="code" class="forgot-field" id="codeInput" disabled required onkeypress="checkEnter(event)">
                    <button type="submit" name="send_code" class="forgot-btn" id="sendCodeButton" <?php if (isset($code_sent)) echo 'style="display: none;"'; ?>>Send Code<span class="material-symbols-outlined">send</span></button>

                    <button type="button" class="forgot-btn" id="verifyButton" style="display:none;" onclick="verifyCode()">Verify</button>
                    <button type="button" class="resend-btn" id="resendButton" style="display: none" disabled>
                
                    <input type="hidden" id="debugCode" value="<?php echo isset($_SESSION['login_code']) ? $_SESSION['login_code'] : ''; ?>">
                </div>
            </form>
        </div>
    </div>

    <script>
        const codeInput = document.getElementById('codeInput');
        const sendCodeButton = document.getElementById('sendCodeButton');
        const verifyButton = document.getElementById('verifyButton');
        const resendButton = document.getElementById('resendButton');
        const alertMessage = document.getElementById('alertMessage');
        const regularText = document.getElementById('regularText');

        // Hide the regular text if an alert message is present
        if (alertMessage.innerHTML.trim() !== '') {
            regularText.style.display = 'none';
        }

        <?php if (isset($code_sent)): ?>
            codeInput.disabled = false;
            sendCodeButton.style.display = 'none';
            verifyButton.style.display = 'inline-block';
            resendButton.style.display = 'inline-block';
            startCooldown();
            startExpirationTimer();
        <?php endif; ?>

        resendButton.addEventListener('click', function() {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "<?php echo $_SERVER['PHP_SELF']; ?>", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onload = function() {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alertMessage.innerHTML = `<span style='color: green;'>${response.message}</span>`;
                    document.getElementById('debugCode').value = response.code;
                    regularText.style.display = 'none';  // Hide regularText when message is shown
                    startCooldown();
                    startExpirationTimer();
                    codeInput.disabled = false;
                    verifyButton.disabled = false;
                } else {
                    alertMessage.innerHTML = `<span style='color: red;'>${response.message}</span>`;
                }
            };

            xhr.send("action=resend_code");
        });

        function verifyCode() {
        const enteredCode = codeInput.value.trim();
        const correctCode = document.getElementById('debugCode').value;

        if (enteredCode === correctCode) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "verify_code.php", true);  // Pointing to a new PHP file that will handle the verification and session set
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            
            xhr.onload = function() {
                if (xhr.responseText === 'success') {
                    window.location.href = 'homepage.php';  // Redirect to homepage if success
                } else {
                    alertMessage.innerHTML = `<span style='color: red;'>${xhr.responseText}</span>`;
                }
            };

            xhr.send("code_verified=true");  // Send a signal that code is verified
        } else {
            alertMessage.innerHTML = `<span style='color: red;'>The code you entered is incorrect.</span>`;
        }
    }


        function startCooldown() {
            let cooldown = 180;
            resendButton.disabled = true;
            resendButton.innerText = `Resend Code (${cooldown}s)`;

            const cooldownTimer = setInterval(function() {
                cooldown--;
                resendButton.innerText = `Resend Code (${cooldown}s)`;

                if (cooldown <= 0) {
                    clearInterval(cooldownTimer);
                    resendButton.disabled = false;
                    resendButton.innerText = "Resend Code";
                }
            }, 1000);
        }

        function startExpirationTimer() {
            setTimeout(function() {
                alertMessage.innerHTML = `<span class='expired'>The code has expired. Please request a new one.</span>`;
                codeInput.disabled = true;
                verifyButton.disabled = true;
            }, 180000); 
        }

        function checkEnter(event) {
            if (event.key === "Enter" || event.keyCode === 13) {
                verifyCode();
            }
        }

    </script>
    
</body>
</html>
