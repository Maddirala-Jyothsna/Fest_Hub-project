<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include("../database/config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']); 

    // Delete review
    $sql = "DELETE FROM reviews WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php?page=reviews&msg=Review+deleted+successfully");
        exit();
    } else {
        echo "Error deleting review: " . $conn->error;
    }
} else {
    header("Location: dashboard.php?page=reviews");
    exit();
}
?>
