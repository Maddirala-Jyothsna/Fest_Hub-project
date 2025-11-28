<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include("../database/config.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "DELETE FROM registrations WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('✅ Registration deleted successfully'); window.location.href='dashboard.php?page=registrations';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    header("Location: dashboard.php?page=registrations");
    exit();
}
