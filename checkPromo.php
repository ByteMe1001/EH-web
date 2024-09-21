<?php
// check_promo.php

// Database connection info
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'promos'; // Assuming your database is named 'promos'

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
    $sql = "SELECT * FROM promo_codes WHERE code = '$promo_code' AND valid_until >= CURDATE() AND uses_left > 0";
    $result = $conn->query($sql); // Directly execute the SQL query without prepared statements

    try {
        $result = $conn->query($sql);
        
        if ($result !== false) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    foreach ($row as $key => $value) {
                        echo htmlspecialchars($key) . ": " . htmlspecialchars($value) . "<br>";
                    }
                    echo "<br>";
                }
            } else {
                echo "No Promo Code found.<br>";
            }
        }
    } catch (mysqli_sql_exception $e) {
        echo "SQL Error: " . htmlspecialchars($e->getMessage()) . "<br>";
    }
}

$conn->close();
?>