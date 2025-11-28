<?php
include("../database/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $college_name = $_POST['college_name'];
    $category = $_POST['category'];
    $event_date = $_POST['event_date'];
    $location = $_POST['location'];
    $participants = intval($_POST['participants']);
    $price = $_POST['price'];
    $organizer = $_POST['organizer'];
    $details = $_POST['details'];

    $poster = null;

    // Check if new poster uploaded
    if (isset($_FILES['poster']) && $_FILES['poster']['error'] == 0) {
        $uploadDir = "../assets/uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $posterPath = $uploadDir . basename($_FILES['poster']['name']);
        move_uploaded_file($_FILES['poster']['tmp_name'], $posterPath);
        $poster = "assets/uploads/" . basename($_FILES['poster']['name']);
    }

    if ($poster) {
        $sql = "UPDATE events 
                SET name=?, college_name=?, category=?, event_date=?, location=?, participants=?, price=?, organizer=?, details=?, poster=? 
                WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssissssi", 
            $name, $college_name, $category, $event_date, $location, 
            $participants, $price, $organizer, $details, $poster, $id
        );
    } else {
        $sql = "UPDATE events 
                SET name=?, college_name=?, category=?, event_date=?, location=?, participants=?, price=?, organizer=?, details=? 
                WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssisssi", 
            $name, $college_name, $category, $event_date, $location, 
            $participants, $price, $organizer, $details, $id
        );
    }

    if ($stmt->execute()) {
        echo "<script>
                alert('✅ Event updated successfully!');
                window.location.href='dashboard.php';
              </script>";
    } else {
        echo "<script>
                alert('❌ Error updating event: " . $stmt->error . "');
                window.location.href='dashboard.php';
              </script>";
    }

    $stmt->close();
}
$conn->close();
?>
