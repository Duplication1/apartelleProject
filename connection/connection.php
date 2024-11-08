    <?php
    $host = 'localhost'; // XAMPP default host
    $db = 'apartelle_db'; // Database name
    $user = 'root'; // Default XAMPP username
    $pass = ''; // XAMPP usually has no password by default

    // Create connection
    $conn = new mysqli($host, $user, $pass, $db);

    // Check connectional
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    ?>