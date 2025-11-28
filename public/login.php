<?php
session_start();

$host = "localhost";
$user = "root";   // MySQL username
$pass = "";       // MySQL password
$db   = "festhub_db"; // Database name

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // fetch admin record
    $sql = "SELECT * FROM admin WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // ⚡ if passwords are hashed in DB use password_verify()
        if ($password === $row['password']) {
            $_SESSION['admin'] = $row['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid Password'); window.location='login.html';</script>";
        }
    } else {
        echo "<script>alert('User not found'); window.location='login.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
