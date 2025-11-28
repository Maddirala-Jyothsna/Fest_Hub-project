<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include("../database/config.php");

$id = $_GET['id'];

// Delete event
$sql = "DELETE FROM events WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: dashboard.php?deleted=1");
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>
