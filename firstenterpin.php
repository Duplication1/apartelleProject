<?php
include_once("connection/connection.php");
$con = connection();
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['submit'])) {
    $pin = $_POST['pin1'] . $_POST['pin2'] . $_POST['pin3'] . $_POST['pin4'] . $_POST['pin5'] . $_POST['pin6'];
    $confirm_pin = $_POST['confirm_pin1'] . $_POST['confirm_pin2'] . $_POST['confirm_pin3'] . $_POST['confirm_pin4'] . $_POST['confirm_pin5'] . $_POST['confirm_pin6'];
    
    // This is a confirmation check to ensure that the user has entered the same pin in both fields

    if ($pin !== $confirm_pin) {
        $error_message = "PIN and Confirm PIN must match.";
    } elseif (preg_match("/^\d{6}$/", $pin)) {
        $user_id = $_SESSION['user_id'];
        $hashed_password = $_SESSION['new_password'];
        $address = $_SESSION['address'];
        $_SESSION['pin'] = $pin;

        // This will insert all of the values from all of the phases of the registration of the user credentials and personal information
        $sql = "UPDATE employee_tbl SET pass='$hashed_password', firstname='{$_SESSION['firstname']}', 
                middlename='{$_SESSION['middlename']}', lastname='{$_SESSION['lastname']}', 
                birthdate='{$_SESSION['birthdate']}', email='{$_SESSION['email']}', phone='{$_SESSION['phone']}', 
                address='$address', gender='{$_SESSION['gender']}', pin='$pin', job='Admin', 
                is_first_login=0 WHERE employee_id='$user_id'";
        $con->query($sql) or die($con->error);

        // This will clear the registration phase session
        session_unset();
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "PIN must be 6 digits.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set PIN</title>
    <link rel="stylesheet" href="css/firstenterpin.css">
</head>
<body>
    <h1>Step 3: Set 6-Digit PIN</h1>
    <?php if (isset($error_message)) { echo "<p style='color:red;'>$error_message</p>"; } ?>
    <form action="firstenterpin.php" method="post">
        <!-- PIN input fields -->
        <label>Enter PIN</label>
        <input type="text" maxlength="1" class="pin" name="pin1" onkeypress="return /[0-9]/i.test(event.key)" oninput="moveToNext(this)" onkeydown="handleKeyNavigation(event, this)" id="pin1" required>
        <input type="text" maxlength="1" class="pin" name="pin2" onkeypress="return /[0-9]/i.test(event.key)" oninput="moveToNext(this)" onkeydown="handleKeyNavigation(event, this)" id="pin2" required>
        <input type="text" maxlength="1" class="pin" name="pin3" onkeypress="return /[0-9]/i.test(event.key)" oninput="moveToNext(this)" onkeydown="handleKeyNavigation(event, this)" id="pin3" required>
        <input type="text" maxlength="1" class="pin" name="pin4" onkeypress="return /[0-9]/i.test(event.key)" oninput="moveToNext(this)" onkeydown="handleKeyNavigation(event, this)" id="pin4" required>
        <input type="text" maxlength="1" class="pin" name="pin5" onkeypress="return /[0-9]/i.test(event.key)" oninput="moveToNext(this)" onkeydown="handleKeyNavigation(event, this)" id="pin5" required>
        <input type="text" maxlength="1" class="pin" name="pin6" onkeypress="return /[0-9]/i.test(event.key)" oninput="moveToNext(this)" onkeydown="handleKeyNavigation(event, this)" id="pin6" required>

        <!-- Confirm PIN input fields -->
        <label>Confirm PIN</label>
        <input type="text" maxlength="1" class="pin" name="confirm_pin1" onkeypress="return /[0-9]/i.test(event.key)" oninput="moveToNext(this)" onkeydown="handleKeyNavigation(event, this)" id="confirm-pin1" required>
        <input type="text" maxlength="1" class="pin" name="confirm_pin2" onkeypress="return /[0-9]/i.test(event.key)" oninput="moveToNext(this)" onkeydown="handleKeyNavigation(event, this)" id="confirm-pin2" required>
        <input type="text" maxlength="1" class="pin" name="confirm_pin3" onkeypress="return /[0-9]/i.test(event.key)" oninput="moveToNext(this)" onkeydown="handleKeyNavigation(event, this)" id="confirm-pin3" required>
        <input type="text" maxlength="1" class="pin" name="confirm_pin4" onkeypress="return /[0-9]/i.test(event.key)" oninput="moveToNext(this)" onkeydown="handleKeyNavigation(event, this)" id="confirm-pin4" required>
        <input type="text" maxlength="1" class="pin" name="confirm_pin5" onkeypress="return /[0-9]/i.test(event.key)" oninput="moveToNext(this)" onkeydown="handleKeyNavigation(event, this)" id="confirm-pin5" required>
        <input type="text" maxlength="1" class="pin" name="confirm_pin6" onkeypress="return /[0-9]/i.test(event.key)" oninput="moveToNext(this)" onkeydown="handleKeyNavigation(event, this)" id="confirm-pin6" required>

        <button type="submit" name="submit">Set PIN</button>
    </form>

    <script src="js/firstenterpin.js"></script>
</body>
</html>
