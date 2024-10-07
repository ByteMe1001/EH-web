<?php
session_start();


// Load the db.ini file
$db_config = parse_ini_file('/var/www/db.ini');

// Extract the credentials
$DATABASE_HOST = $db_config['host'];
$DATABASE_USER = $db_config['username'];
$DATABASE_PASS = $db_config['password'];
$DATABASE_NAME = $db_config['database'];

// Try and connect using the info from db.ini
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if ( !isset($_POST['username'], $_POST['password']) ) {
	// Could not get the data that should have been sent.
	exit('Please fill both the username and password fields!');
}

// Prepare SQL to check if the account exists
if ($stmt = $con->prepare('SELECT id, password, failed_attempts, last_attempt FROM accounts WHERE username = ?')) {
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password, $failed_attempts, $last_attempt);
        $stmt->fetch();

        // Check if the account is locked (e.g., after too many failed attempts)
        $lockout_time = 10 * 60; // Lockout period (10 minutes)
        $current_time = time();
        $last_attempt_time = strtotime($last_attempt);

        // Check if the user is locked out
        if ($failed_attempts >= 5 && ($current_time - $last_attempt_time) < $lockout_time) {
            exit('Account is temporarily locked. Please try again later.');
        }

        // User submitted password
        $submitted_password = $_POST['password'];

        // Hash the submitted password with MD5
        $md5_hash = md5($submitted_password);
        $fake_bcrypt_hash = '$2y$' . $md5_hash;

        // Verify password
        if ($fake_bcrypt_hash === $password) {
            // Reset failed_attempts on successful login
            $stmt = $con->prepare('UPDATE accounts SET failed_attempts = 0, last_attempt = NULL WHERE id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();

            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            header('Location: secret.php');
        } else {
            // Increment failed_attempts
            $stmt = $con->prepare('UPDATE accounts SET failed_attempts = failed_attempts + 1, last_attempt = NOW() WHERE id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();

            echo 'Incorrect username and/or password!';
        }
    } else {
        echo 'Incorrect username and/or password!';
    }

    $stmt->close();
}
?>