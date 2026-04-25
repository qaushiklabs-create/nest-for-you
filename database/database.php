<?php
// Database connection settings
$servername = "127.0.0.1"; // Database host
$username = "nestforyou_user"; // Database username
$password = "YOUR_DB_PASSWORD"; // Database password
$dbname = "nestforyou_root"; // Database name
$port = 3306; // Database port (default MySQL port is 3306)

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check the connection
if ($conn->connect_error) {
    // Return a JSON response with error message
    echo json_encode([
        'status' => 'error',
        'message' => 'Connection failed: ' . $conn->connect_error
    ]);
    exit();
}
?>
 