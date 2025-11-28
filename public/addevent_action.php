<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include("../database/config.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name         = $_POST['name'];
    $college_name = $_POST['college_name'];
    $details      = $_POST['details'];
    $category     = $_POST['category'];
    $event_date   = $_POST['event_date'];
    $location     = $_POST['location'];
    $participants = $_POST['participants'];
    $price        = $_POST['price'];
    $organizer    = $_POST['organizer'];

    // handle poster upload
    $posterPath = "";
    if (!empty($_FILES['poster']['name'])) {
        $targetDir = "uploads/";   // folder inside /admin
        if (!file_exists("../" . $targetDir)) {
            mkdir("../" . $targetDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES["poster"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["poster"]["tmp_name"], "../" . $targetFilePath)) {
            $posterPath = $targetFilePath;  // always like uploads/filename.jpg
        }
    }

    // ✅ Insert SQL with college_name included
    $sql = "INSERT INTO events 
            (name, college_name, details, category, event_date, location, participants, price, organizer, poster, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);

    // ✅ Choose correct binding types
    // s = string, i = integer, d = double
    $stmt->bind_param(
        "ssssssisss",
        $name,
        $college_name,
        $details,
        $category,
        $event_date,
        $location,
        $participants,  // int
        $price,         // string (if varchar) or change to i/d if numeric
        $organizer,
        $posterPath
    );

    if ($stmt->execute()) {
        header("Location: dashboard.php?success=1");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
