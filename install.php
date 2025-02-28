<?php
// Connect to MySQL (without selecting a database yet)
$servername = "localhost";
$username = "root";  // Default XAMPP username
$password = "";      // Default password (empty for XAMPP)
$dbname = "biometricattendance";

// Create connection (without selecting a database)
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the database exists
$db_check = $conn->query("SHOW DATABASES LIKE '$dbname'");
if ($db_check->num_rows == 0) {
    // If database doesn't exist, create it
    $sql = "CREATE DATABASE $dbname";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully.<br>";
    } else {
        die("Error creating database: " . $conn->error);
    }
} else {
    echo "Database already exists.<br>";
}

// Now connect to the specific database
$conn->select_db($dbname);

// SQL to create 'users' table
$sql = "CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` varchar(100) NOT NULL,
    `serialnumber` double NOT NULL,
    `gender` varchar(10) NOT NULL,
    `email` varchar(50) NOT NULL,
    `fingerprint_id` int(11) NOT NULL UNIQUE,
    `fingerprint_select` tinyint(1) NOT NULL DEFAULT '0',
    `user_date` date NOT NULL,
    `time_in` time NOT NULL,
    `del_fingerid` tinyint(1) NOT NULL DEFAULT '0',
    `add_fingerid` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

if ($conn->query($sql) === TRUE) {
    echo "Table 'users' created successfully.<br>";
} else {
    echo "Error creating 'users' table: " . $conn->error . "<br>";
}

// SQL to create 'users_logs' table
$sql = "CREATE TABLE IF NOT EXISTS `users_logs` (
    `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` varchar(100) NOT NULL,
    `serialnumber` double NOT NULL,
    `fingerprint_id` int(5) NOT NULL,
    `checkindate` date NOT NULL,
    `timein` time NOT NULL,
    `timeout` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

if ($conn->query($sql) === TRUE) {
    echo "Table 'users_logs' created successfully.<br>";
} else {
    echo "Error creating 'users_logs' table: " . $conn->error . "<br>";
}

// Close connection
$conn->close();
?>
