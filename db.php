<?php

// Database server
$servername = "localhost";

// MySQL username
$username = "root";

// MySQL password
$password = "";

// Database name
$dbname = "college_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Uncomment the line below if you want to test the connection.
// echo "Database connected successfully.";

?>