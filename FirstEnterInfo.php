<?php
include_once("connection/connection.php");
$con = connection();
session_start();

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php"); // Redirect to the home page
    exit();
}

// Check if user is already logged in
if (!isset($_SESSION['is_first_login'])) {
    header("Location: login.php"); // Redirect to the home page
    exit();
}

if (isset($_POST['submit'])) {
    $_SESSION['firstname'] = $_POST['firstname'];
    $_SESSION['middlename'] = $_POST['middlename'];
    $_SESSION['lastname'] = $_POST['lastname'];
    $_SESSION['birthdate'] = $_POST['birthdate'];
    $_SESSION['email'] = $_POST['email'];

    // Validate and store phone number
    if (isset($_POST['phone']) && is_numeric($_POST['phone']) && strlen($_POST['phone']) <= 11) {
        $_SESSION['phone'] = $_POST['phone'];
    } else {
        $_SESSION['phone'] = ''; // Or handle error more gracefully
    }

    $_SESSION['house_no'] = $_POST['house_no'];
    $_SESSION['street_name'] = $_POST['street_name'];
    $_SESSION['barangay_name'] = $_POST['barangay_name'];
    $_SESSION['city'] = $_POST['city'];
    $_SESSION['province'] = $_POST['province'];
    $_SESSION['zip_code'] = $_POST['zip_code'];

    // Combine address fields
    $_SESSION['address'] = $_POST['house_no'] . ', ' . $_POST['street_name'] . ', ' . $_POST['barangay_name'] . ', ' . $_POST['city'] . ', ' . $_POST['province'] . ', ' . $_POST['zip_code'];
    $_SESSION['gender'] = $_POST['gender'];

    header("Location: Firstenterpin.php");
    exit();
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
            <img src="img/folder-img.png" alt="folder-png">
            <h1>The more we know, the better we can connect!</h1>
            <p>Share your personal information and details with us—we want to get to know you better!</p>
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
                        <a>3</a>
                        <p>Set PIN Password</p>
                    </li>
                </ul>
            </div>

            <div class="create-id" id="create-id">
                <form action="" method="post">
                    <div class="create-id-child">
                        <h1>Personal Information</h1>
                        <div class="info-cont">
                            <div>
                                <label>First Name</label>
                                <input type="text" name="firstname" id="firstname" class="text-field text-field-first-name" value="<?php echo isset($_SESSION['firstname']) ? htmlspecialchars($_SESSION['firstname']) : ''; ?>" required>
                            </div>

                            <div> 
                                <label>Middle Name</label>
                                <input type="text" name="middlename" id="middlename" class="text-field text-field-first-name" value="<?php echo isset($_SESSION['middlename']) ? htmlspecialchars($_SESSION['middlename']) : ''; ?>">
                            </div>

                            <div>
                                <label>Last Name</label>
                                <input type="text" name="lastname" id="lastname" class="text-field text-field-first-name" value="<?php echo isset($_SESSION['lastname']) ? htmlspecialchars($_SESSION['lastname']) : ''; ?>" required>
                            </div>
                        </div>

                        <div class="info-cont">
                            <div>
                                <label>Email Address</label>
                                <input type="text" name="email" id="email" class="text-field text-field-emmail" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" required>
                            </div>

                            <div>
                                <label for="phone">Phone No</label>
                                <input type="number" name="phone" id="phone" class="text-field" required oninput="this.value = this.value.slice(0, 11)" value="<?php echo isset($_SESSION['phone']) ? htmlspecialchars($_SESSION['phone']) : ''; ?>" />
                                <span id="error-message" style="color: red; display: none;"></span>
                            </div>
                        </div>

                        <div class="info-cont">
                            <div>
                                <label>Gender</label>
                                <select name="gender" id="gender" class="text-field" required>
                                    <option value="" disabled selected></option>
                                    <option value="Male" <?php echo (isset($_SESSION['gender']) && $_SESSION['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo (isset($_SESSION['gender']) && $_SESSION['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                    <option value="Other" <?php echo (isset($_SESSION['gender']) && $_SESSION['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>

                            <div>
                                <label>Birthdate</label>
                                <input type="date" name="birthdate" id="birthdate" class="text-field" value="<?php echo isset($_SESSION['birthdate']) ? htmlspecialchars($_SESSION['birthdate']) : ''; ?>" required>
                            </div>
                        </div>

                        <h1>Address Information</h1>
                        <div class="info-cont">
                            <div>
                                <label>House No.</label>
                                <input type="text" name="house_no" id="house_no" class="text-field text-field-house" value="<?php echo isset($_SESSION['house_no']) ? htmlspecialchars($_SESSION['house_no']) : ''; ?>" required>
                            </div>

                            <div>
                                <label>Street Name</label>
                                <input type="text" name="street_name" id="street_name" class="text-field text-field-street" value="<?php echo isset($_SESSION['street_name']) ? htmlspecialchars($_SESSION['street_name']) : ''; ?>" required>
                            </div>

                            <div>
                                <label>Barangay Name</label>
                                <input type="text" name="barangay_name" id="barangay_name" class="text-field text-field-street" value="<?php echo isset($_SESSION['barangay_name']) ? htmlspecialchars($_SESSION['barangay_name']) : ''; ?>" required>
                            </div>
                        </div>

                        <div class="info-cont">
                            <div>
                                <label>City/Municipality</label>
                                <select id="city" name="city" class="text-field text-field-city" required>
                                    <option value="" disabled selected></option>
                                    <option value="Caloocan City" <?php echo (isset($_SESSION['city']) && $_SESSION['city'] == 'Caloocan City') ? 'selected' : ''; ?>>Caloocan</option>
                                    <option value="Las Pinas City" <?php echo (isset($_SESSION['city']) && $_SESSION['city'] == 'Las Pinas') ? 'selected' : ''; ?>>Las Piñas</option>
                                    <option value="Makati City" <?php echo (isset($_SESSION['city']) && $_SESSION['city'] == 'Makati') ? 'selected' : ''; ?>>Makati</option>
                                    <option value="Manila City" <?php echo (isset($_SESSION['city']) && $_SESSION['city'] == 'Manila') ? 'selected' : ''; ?>>Manila</option>
                                    <option value="Marikina City" <?php echo (isset($_SESSION['city']) && $_SESSION['city'] == 'Marikina') ? 'selected' : ''; ?>>Marikina</option>
                                    <option value="Muntinlupa City" <?php echo (isset($_SESSION['city']) && $_SESSION['city'] == 'Muntinlupa') ? 'selected' : ''; ?>>Muntinlupa</option>
                                    <option value="Navotas City" <?php echo (isset($_SESSION['city']) && $_SESSION['city'] == 'Navotas') ? 'selected' : ''; ?>>Navotas</option>
                                    <option value="Paranaque City" <?php echo (isset($_SESSION['city']) && $_SESSION['city'] == 'Parañaque') ? 'selected' : ''; ?>>Parañaque</option>
                                    <option value="Pasay City" <?php echo (isset($_SESSION['city']) && $_SESSION['city'] == 'Pasay City') ? 'selected' : ''; ?>>Pasay</option>
                                    <option value="Pasig City" <?php echo (isset($_SESSION['city']) && $_SESSION['city'] == 'Las Pinas City') ? 'selected' : ''; ?>>Pasig</option>
                                    <option value="Quezon City" <?php echo (isset($_SESSION['city']) && $_SESSION['city'] == 'Quezon City') ? 'selected' : ''; ?>>Quezon City</option>
                                    <option value="San Juan" <?php echo (isset($_SESSION['city']) && $_SESSION['city'] == 'San Juan') ? 'selected' : ''; ?>>San Juan</option>
                                    <option value="Taguig City" <?php echo (isset($_SESSION['city']) && $_SESSION['city'] == 'Taguig City') ? 'selected' : ''; ?>>Taguig</option>
                                    <option value="Valenzuela City" <?php echo (isset($_SESSION['city']) && $_SESSION['city'] == 'Valenzuela City') ? 'selected' : ''; ?>>Valenzuela</option>
                                    <!-- Add more cities as required -->
                                </select>
                            </div>

                            <div>
                                <label>Province</label>
                                <input type="text" name="province" id="province" class="text-field text-field-city" value="<?php echo isset($_SESSION['province']) ? htmlspecialchars($_SESSION['province']) : ''; ?>" required>
                            </div>

                            <div>
                                <label>Zip Code</label>
                                <input type="text" name="zip_code" id="zip_code" class="text-field text-field-zip" value="<?php echo isset($_SESSION['zip_code']) ? htmlspecialchars($_SESSION['zip_code']) : ''; ?>" required>
                            </div>
                        </div>
                        <button type="submit" name="submit" class="change-pass-btn">Submit Details<span class="material-symbols-outlined"> chevron_right </span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="firstenterinfo.js"></script>
    <script>
        // Alert Message for Redirecting
        // Define exception pages
        const exceptions = ["Firstchangepass.php", "firstenterinfo.php", "firstenterpin.php"];
        
        // Get all navigation links
        const navLinks = document.querySelectorAll(".progress-cont a");

        // Add event listener to each link
        navLinks.forEach(link => {
            link.addEventListener("click", function(event) {
                const targetPage = link.getAttribute("href");

                // Check if target page is not in exceptions
                if (!exceptions.includes(targetPage)) {
                    event.preventDefault(); // Stop navigation
                    
                    // Show confirmation dialog
                    const userConfirmed = confirm("Are you sure? All fields will be cleared.");
                    
                    if (userConfirmed) {
                        // Clear the session using AJAX
                        fetch("clear_session.php")
                            .then(() => {
                                // Redirect to the clicked page
                                window.location.href = targetPage;
                            })
                            .catch(err => console.error("Failed to clear session:", err));
                    }
                }
            });
        });
    </script>
</body>

</html>
