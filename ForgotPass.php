<?php

include_once("connection/connection.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

session_start();
$con = connection();

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Fetch the user email
$sql = "SELECT email FROM manager_tbl WHERE job = 'om' LIMIT 1";
$result = $con->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    $email_label = $row['email'];
    $_SESSION['email'] = $email_label;
} else {
    $email_label = "No email found";
}

// Function to send a reset code via email
function sendResetCode($email_label)
{
    unset($_SESSION['reset_code']);

    $reset_code = rand(100000, 999999);
    $_SESSION['reset_code'] = $reset_code;

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'novastarapartelle@gmail.com';
        $mail->Password = 'ipjx rbaz njzz udgc';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('noreply@novastarapartelle.com', 'Novastar Apartelle');
        $mail->addAddress($email_label);
        $mail->isHTML(true);
        $mail->Subject = 'Reset Your Password';
        $mail->Body = "Your Password Reset code is: <strong>$reset_code</strong>";

        $mail->send();
        return ["success" => true, "message" => "Password Reset code sent to $email_label", "code" => $reset_code];
    } catch (Exception $e) {
        return ["success" => false, "message" => "Error: {$mail->ErrorInfo}"];
    }
}

// Handle sending the reset code
if (isset($_POST['send_code']) && $email_label !== "No email found") {
    $response = sendResetCode($email_label);
    $alert_message = $response['message'];
    $code_sent = true;
}

// Check for AJAX request to resend the code
if (isset($_POST['action']) && $_POST['action'] == 'resend_code' && $email_label !== "No email found") {
    $response = sendResetCode($email_label);
    echo json_encode($response);
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
                <h1>Reset your Password</h1>

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
                        <!-- <span class="material-symbols-outlined">redo</span> -->
                    </button>
                    <input type="hidden" id="debugCode" value="<?php echo isset($_SESSION['reset_code']) ? $_SESSION['reset_code'] : ''; ?>">
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
                    startCooldown();
                    startExpirationTimer();
                    codeInput.disabled = false; // Enable input field
                    verifyButton.disabled = false; // Enable verify button
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
                window.location.href = 'resetpass.php';
            } else {
                alertMessage.innerHTML = `<span style='color: red;'>The code you entered is incorrect.</span>`;
            }
        }

        function startCooldown() {
            let cooldown = 180;
            resendButton.disabled = true;
            resendButton.innerHTML = `<span class="material-symbols-outlined">redo</span>Resend Code (${cooldown}s)`;

            const cooldownTimer = setInterval(function() {
                cooldown--;
                resendButton.innerHTML = `<span class="material-symbols-outlined">redo</span>Resend Code (${cooldown}s)`;

                if (cooldown <= 0) {
                    clearInterval(cooldownTimer);
                    resendButton.disabled = false;
                    resendButton.innerHTML = `<span class="material-symbols-outlined">redo</span>Resend Code`;
                }
            }, 1000);
        }

        function startExpirationTimer() {
            setTimeout(function() {
                alertMessage.innerHTML = `<span class='expired'>The code has expired. Please request a new one.</span>`;
                codeInput.disabled = true; // Disable input field
                verifyButton.disabled = true; // Disable verify button
            }, 180000); // 3 minutes expiration
        }
    </script>
</body>

</html>