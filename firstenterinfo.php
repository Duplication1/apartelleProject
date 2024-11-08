<?php
include_once("connection/connection.php");
$con = connection();
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $_SESSION['firstname'] = $_POST['firstname'];
    $_SESSION['middlename'] = $_POST['middlename'];
    $_SESSION['lastname'] = $_POST['lastname'];
    $_SESSION['birthdate'] = $_POST['birthdate'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['phone'] = $_POST['phone'];

    // Combination of address fields
    $_SESSION['address'] = $_POST['house_no'] . ', ' . $_POST['street_name'] . ', ' . $_POST['barangay_name'] . ', ' . $_POST['city'] . ', ' . $_POST['province'] . ', ' . $_POST['zip_code'];
    $_SESSION['gender'] = $_POST['gender'];

    header("Location: firstenterpin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Information Registration</title>  
</head>
<body>
    <div class="navbar">
        <a href="#home" class="logo"></a>
        <div>
            <img src="" alt="logo">
        </div>

        <div class="menu-wrapper">
            <ul class="menu">
                <li><a href="#home" class="a home-btn">Home</a></li>
                <li><a href=""></a></li>
            </ul>
        </div>
    </div>

    <div class="create-id" id="create-id">
        <div class="create-id-container">
            <h1>Personal Information</h1>
                <form action="" method="post">
                    <div class="create-id-child">
                        <div>
                            <label>First Name</label>
                            <input type="text" name="firstname" id="firstname" class="form-field" required>
                        </div>

                        <div>
                            <label>Middle Name</label>
                            <input type="text" name="middlename" id="middlename">
                        </div>

                        <div>
                            <label>Last Name</label>
                            <input type="text" name="lastname" id="lastname" class="form-field" required>
                        </div>

                        <div>
                            <label>Birthdate</label>
                            <input type="date" name="birthdate" id="birthdate" class="form-field" required>
                        </div>

                        <div>
                            <label>Email Address</label>
                            <input type="text" name="email" id="email" class="form-field" required>
                        </div>

                        <div>
                            <label for="phone">Phone No</label>
                            <input type="text" name="phone" id="phone" maxlength="11" required onkeypress="return /[0-9]/i.test(event.key)">
                        </div>

                        <div>
                            <label>House No.</label>
                            <input type="text" name="house_no" id="house_no" class="form-field" required>
                        </div>

                        <div>
                            <label>Street Name</label>
                            <input type="text" name="street_name" id="street_name" class="form-field" required>
                        </div>

                        <div>
                            <label>Barangay Name</label>
                            <input type="text" name="barangay_name" id="barangay_name" class="form-field" required>
                        </div>

                        <div>
                            <label>City/Municipality</label>
                            <select id="city" name="city" required>
                                <option value="" disabled selected>Select your option</option>
                                <option value="Caloocan">Caloocan</option>
                                <option value="Las Piñas">Las Piñas</option>
                                <option value="Makati">Makati</option>
                                <option value="Manila">Manila</option>
                                <option value="Marikina">Marikina</option>
                                <option value="Muntinlupa">Muntinlupa</option>
                                <option value="Navotas">Navotas</option>
                                <option value="Paranaque">Parañaque</option>
                                <option value="Pasay">Pasay</option>
                                <option value="Pasig">Pasig</option>
                                <option value="Quezon City">Quezon City</option>
                                <option value="San Juan">San Juan</option>
                                <option value="Taguig">Taguig</option>
                                <option value="Valenzuela">Valenzuela</option>
                            </select>
                        </div>

                        <div>
                            <label>Province</label>
                            <input type="text" name="province" id="province" class="form-field" required>
                        </div>

                        <div>
                            <label>Zip Code</label>
                            <input type="text" name="zip_code" id="zip_code" class="form-field" onkeypress="return /[0-9]/i.test(event.key)">
                        </div>

                        <div>
                            <label>Gender</label>
                            <select name="gender" id="gender" class="form-field" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <button type="submit" name="submit">Submit</button>


                    </div>
                </form>
        </div>        
    </div>

    <script src="firstenterinfo.js">

    </script>

</body>
</html>
