<?php
// check_promo.php

// Load the db.ini file
$db_config = parse_ini_file('/var/www/db.ini');

// Extract the credentials
$DATABASE_HOST = $db_config['host'];
$DATABASE_USER = $db_config['username'];
$DATABASE_PASS = $db_config['password'];
$DATABASE_NAME = $db_config['database2'];

// Connect to the database
$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Check if the promo code was submitted
if (!isset($_POST['promo_code'])) {
    exit('Please enter a promo code!');
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $promo_code = $_POST['promo_code']; // Directly using the input without sanitization

    // SQL query is constructed by concatenating user input directly into the query string
    $sql = "SELECT * FROM promo_codes WHERE code = '$promo_code' AND valid_until >= CURDATE() AND uses_left > 0;";
    $result = $conn->query($sql); // Directly execute the SQL query 

    try {
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "Promo code is valid! Discount: " . $row['discount_percentage'] . "%";
            
        } else {
            echo "Invalid or expired promo code.";
        }

    } catch (mysqli_sql_exception $e) {
        echo "SQL Error: " . htmlspecialchars($e->getMessage()) . "<br>";
    }
}

$conn->close();
?>