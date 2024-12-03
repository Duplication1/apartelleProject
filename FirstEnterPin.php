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
    // Concatenate pin fields directly
    $pin = $_POST['pin1'] . $_POST['pin2'] . $_POST['pin3'] . $_POST['pin4'] . $_POST['pin5'] . $_POST['pin6'];
    $confirm_pin = $_POST['confirm_pin1'] . $_POST['confirm_pin2'] . $_POST['confirm_pin3'] . $_POST['confirm_pin4'] . $_POST['confirm_pin5'] . $_POST['confirm_pin6'];

    // Validate PIN format
    if (!preg_match("/^\d{6}$/", $pin)) {
        $error_message = "PIN must be 6 digits.";
    } elseif ($pin !== $confirm_pin) {
        // Check if PIN and confirm PIN match
        $error_message = "PIN and Confirm PIN must match.";
    } else {
        // Proceed with database update
        $user_id = $_SESSION['user_id'];
        $hashed_password = $_SESSION['new_password'];
        $address = $_SESSION['address'];
        $_SESSION['user_id'] = $row['employee_id'];

        $sql = "UPDATE manager_tbl SET
                    FirstName='{$_SESSION['firstname']}', 
                    MiddleName='{$_SESSION['middlename']}', 
                    LastName='{$_SESSION['lastname']}', 
                    Birthdate='{$_SESSION['birthdate']}', 
                    Email='{$_SESSION['email']}', 
                    ContactNumber='{$_SESSION['phone']}', 
                    Address='$address', 
                    Gender='{$_SESSION['gender']}', 
                    `pass`='$hashed_password', 
                    email='{$_SESSION['email']}', 
                    pin='$pin', 
                    is_first_login=0 
                WHERE employee_id='$user_id'";

        $con->query($sql) or die($con->error);

        // Clear session and redirect to dashboard
        session_unset();
        unset($_SESSION['firstname'], $_SESSION['middlename'], $_SESSION['lastname'], $_SESSION['birthdate'], $_SESSION['email'], $_SESSION['phone'], $_SESSION['address'], $_SESSION['gender'], $_SESSION['pass'], $_SESSION['pin1'], $_SESSION['pin2'], $_SESSION['pin3'], $_SESSION['pin4'], $_SESSION['pin5'], $_SESSION['pin6'], $_SESSION['confirm-pin1'], $_SESSION['confirm-pin2'], $_SESSION['confirm-pin3'], $_SESSION['confirm-pin4'], $_SESSION['confirm-pin5'], $_SESSION['confirm-pin6'], $_SESSION['house_no'], $_SESSION['street_name'], $_SESSION['barangay_name'], $_SESSION['city'], $_SESSION['province'], $_SESSION['zip_code'], $_SESSION['is_first_login']);
        header("Location: homepage.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Information Registration</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="css/Login.css">
</head>

<body>
    <div class="change-main">
        <div class="change-cont1">
            <img src="img/key-img.png" alt="folder-png">
            <h1>Concerned about your privacy? We got you!</h1>
            <p>Set a 6-digit PIN to protect your privacy when you step away from your workspace or computer. This adds a layer of security to keep your personal information safe from unauthorized access.</p>
        </div>

        <div class="change-cont2 change-cont-personal">
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
                        <a href="Firstenterinfo.php" class="progress-unique">2</a>
                        <p class="progress-txt">Personal Information</p>
                        <div></div>
                    </li>
                </ul>

                <ul>
                    <li>
                        <a href="enterpin.php" class="progress-unique">3</a>
                        <p class="progress-txt">Set PIN Password</p>
                    </li>
                </ul>
            </div>

            <div class="form-box">
                

                <form action="Firstenterpin.php" method="post">

                    <h1>Set Pin</h1>
                    <div>
                        <input type="text" class="pin-text" maxlength="1" name="pin1" id="pin1" onkeypress="return /[0-9]/i.test(event.key)" oninput="moveToNext(this)" onkeydown="handleKeyNavigation(event, this)" value="<?php echo isset($_SESSION['pin1']) ? $_SESSION['pin1'] : ''; ?>" required>
                        <input type="text" class="pin-text" maxlength="1"  name="pin2" id="pin2" onkeypress="return /[0-9]/i.test(event.key)" oninput="moveToNext(this)" onkeydown="handleKeyNavigation(event, this)" value="<?php echo isset($_SESSION['pin2']) ? $_SESSION['pin2'] : ''; ?>" required>
                        <input type="text" class="pin-text" maxlength="1"  name="pin3" id="pin3" onkeypress="return /[0-9]/i.test(event.key)" oninput="moveToNext(this)" onkeydown="handleKeyNavigation(event, this)" value="<?php echo isset($_SESSION['pin3']) ? $_SESSION['pin3'] : ''; ?>" required>
                        <input type="text" class="pin-text" maxlength="1" name="pin4" id="pin4" onkeypress="return /[0-9]/i.test(event.key)" oninput="moveToNext(this)" onkeydown="handleKeyNavigation(event, this)" value="<?php echo isset($_SESSION['pin4']) ? $_SESSION['pin4'] : ''; ?>" required>
                        <input type="text" class="pin-text" maxlength="1"  name="pin5" id="pin5" onkeypress="return /[0-9]/i.test(event.key)" oninput="moveToNext(this)" onkeydown="handleKeyNavigation(event, this)" value="<?php echo isset($_SESSION['pin5']) ? $_SESSION['pin5'] : ''; ?>" required>
                        <input type="text" class="pin-text" maxlength="1"  name="pin6" id="pin6" onkeypress="return /[0-9]/i.test(event.key)" oninput="moveToNext(this)" onkeydown="handleKeyNavigation(event, this)" value="<?php echo isset($_SESSION['pin6']) ? $_SESSION['pin6'] : ''; ?>" required>
                    </div>

                    <h1>Confirm Pin</h1>
                    <div>
                        <input type="text" class="pin-text" maxlength="1"  name="confirm_pin1" id="confirm-pin1" onkeypress="return /[0-9]/i.test(event.key)" oninput="moveToNext(this)" onkeydown="handleKeyNavigation(event, this)" value="<?php echo isset($_SESSION['confirm-pin1']) ? $_SESSION['confirm-pin1'] : ''; ?>" required>
                        <input type="text" class="pin-text" maxlength="1"  name="confirm_pin2" id="confirm-pin2" onkeypress="return /[0-9]/i.test(event.key)" oninput="moveToNext(this)" onkeydown="handleKeyNavigation(event, this)" value="<?php echo isset($_SESSION['confirm-pin2']) ? $_SESSION['confirm-pin2'] : ''; ?>" required>
                        <input type="text" class="pin-text" maxlength="1"  name="confirm_pin3" id="confirm-pin3" onkeypress="return /[0-9]/i.test(event.key)" oninput="moveToNext(this)" onkeydown="handleKeyNavigation(event, this)" value="<?php echo isset($_SESSION['confirm-pin3']) ? $_SESSION['confirm-pin3'] : ''; ?>" required>
                        <input type="text" class="pin-text" maxlength="1"  name="confirm_pin4" id="confirm-pin4" onkeypress="return /[0-9]/i.test(event.key)" oninput="moveToNext(this)" onkeydown="handleKeyNavigation(event, this)" value="<?php echo isset($_SESSION['confirm-pin4']) ? $_SESSION['confirm-pin4'] : ''; ?>" required>
                        <input type="text" class="pin-text" maxlength="1"  name="confirm_pin5" id="confirm-pin5" onkeypress="return /[0-9]/i.test(event.key)" oninput="moveToNext(this)" onkeydown="handleKeyNavigation(event, this)" value="<?php echo isset($_SESSION['confirm-pin5']) ? $_SESSION['confirm-pin5'] : ''; ?>" required>
                        <input type="text" class="pin-text" maxlength="1"  name="confirm_pin6" id="confirm-pin6" onkeypress="return /[0-9]/i.test(event.key)" oninput="moveToNext(this)" onkeydown="handleKeyNavigation(event, this)" value="<?php echo isset($_SESSION['confirm-pin6']) ? $_SESSION['confirm-pin6'] : ''; ?>" required>
                    </div>

                    <?php if (isset($error_message)) {
                    echo "<p style='color:red;'>$error_message</p>";
                } ?>

                    <button type="submit" name="submit" class="change-pass-btn pin-btn">Set PIN</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container">

    </div>
    <script src="js/firstenterpin.js"></script>
    <script>
        // Define exception pages
        const exceptions = ["Firstchangepass.php", "firstenterinfo.php", "firstenterpin.php"];
        
        // Detect back/forward navigation
        window.addEventListener("popstate", function (event) {
            // Get the current URL path
            const currentPage = window.location.pathname.split("/").pop();
            
            // Check if the page is not in the exception list
            if (!exceptions.includes(currentPage)) {
                // Ask for confirmation
                const userConfirmed = confirm("Are you sure? All fields will be cleared.");
                
                if (userConfirmed) {
                    // Clear the session using AJAX
                    fetch("module/clear_session.php")
                        .then(() => {
                            // Allow navigation
                            window.history.go();
                        })
                        .catch(err => console.error("Failed to clear session:", err));
                } else {
                    // Block navigation by pushing the current state back
                    window.history.pushState(null, "", window.location.href);
                }
            }
        });

        // Initialize the current state
        window.history.replaceState(null, "", window.location.href);
    </script>

</body>

</html>