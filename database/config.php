<?php
$host = "localhost";
$user = "root";  // default XAMPP user
$pass = "";      // default XAMPP password is empty
$db   = "festhub_db"; // ✅ use your database name

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
