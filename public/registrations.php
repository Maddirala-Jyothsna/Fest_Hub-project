<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include("../config.php");

// Fetch all registrations with event details
$sql = "SELECT r.id, r.student_name, r.email, r.phone, e.name AS event_name, e.event_date
        FROM registrations r
        JOIN events e ON r.event_id = e.id
        ORDER BY r.id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Student Registrations</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: url('../assets/bg.jpg') no-repeat center center/cover;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
      color: #fff;
    }

    .container {
      width: 90%;
      margin-top: 50px;
      background: rgba(255,255,255,0.1);
      backdrop-filter: blur(12px);
      border-radius: 20px;
      padding: 20px;
      box-shadow: 0 8px 32px rgba(0,0,0,0.3);
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      overflow: hidden;
      border-radius: 12px;
    }

    table thead {
      background: rgba(0, 114, 255, 0.8);
      color: #fff;
    }

    table th, table td {
      padding: 12px 15px;
      text-align: center;
    }

    table tbody tr:nth-child(even) {
      background: rgba(255, 255, 255, 0.05);
    }

    .btn-back {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 18px;
      background: linear-gradient(135deg, #00c6ff, #0072ff);
      color: #fff;
      text-decoration: none;
      border-radius: 10px;
      transition: 0.3s;
    }

    .btn-back:hover {
      background: linear-gradient(135deg, #0072ff, #00c6ff);
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>📋 Student Registrations</h2>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Student Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Event</th>
          <th>Event Date</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) { ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td><?php echo $row['student_name']; ?></td>
              <td><?php echo $row['email']; ?></td>
              <td><?php echo $row['phone']; ?></td>
              <td><?php echo $row['event_name']; ?></td>
              <td><?php echo $row['event_date']; ?></td>
            </tr>
        <?php } } else { ?>
          <tr><td colspan="6">No registrations found.</td></tr>
        <?php } ?>
      </tbody>
    </table>

    <div style="text-align:center;">
      <a href="dashboard.php" class="btn-back">⬅ Back to Dashboard</a>
    </div>
  </div>
</body>
</html>
