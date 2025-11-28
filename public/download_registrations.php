<?php
include("../database/config.php");

// File name
$filename = "registrations_" . date('Y-m-d') . ".csv";

// Headers to force download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

// Open output stream
$output = fopen("php://output", "w");

// Add column headers
fputcsv($output, ['ID', 'Student Name', 'Email', 'Phone', 'Roll No', 'College', 'Event', 'Registered At']);

// Fetch data
$sql = "SELECT r.id, r.student_name, r.email, r.phone, r.roll_no, r.college_name, e.name AS event_name, r.created_at 
        FROM registrations r 
        JOIN events e ON r.event_id = e.id
        ORDER BY r.created_at DESC";
$result = $conn->query($sql);

// Write rows
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['id'],
            $row['student_name'],
            $row['email'],
            "'" . $row['phone'],      // Treat phone as text
            "'" . $row['roll_no'],    // Treat roll number as text
            $row['college_name'],
            $row['event_name'],
            $row['created_at']
        ]);
    }
}

fclose($output);
exit;
?>