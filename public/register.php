<?php
include __DIR__ . '/../database/config.php';

if (!isset($_GET['event_id'])) {
    die("Invalid request");
}
$event_id = intval($_GET['event_id']);

// Fetch event details (optional, to show event name)
$event = $conn->query("SELECT name FROM events WHERE id=$event_id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = $conn->real_escape_string($_POST['name']);
    $email   = $conn->real_escape_string($_POST['email']);
    $phone   = $conn->real_escape_string($_POST['phone']);
    $roll    = $conn->real_escape_string($_POST['roll']);
    $college = $conn->real_escape_string($_POST['college']);

    $sql = "INSERT INTO registrations (event_id, student_name, email, phone, roll_no, college_name, created_at) 
            VALUES ('$event_id', '$name', '$email', '$phone', '$roll', '$college', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('🎉 Registration successful for {$event['name']}!');window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - FestHub</title>
  <style>
    * { box-sizing: border-box; font-family: 'Poppins', sans-serif; }
    body {
      margin: 0; padding: 0;
      background: url('../assets/images/regi-back.jpg') no-repeat center center/cover;
      display: flex; justify-content: center; align-items: center;
      min-height: 100vh;
    }
    .container {
      width: 400px; padding: 30px;
      background: rgba(0, 0, 0, 0.6);
      border-radius: 12px;
      backdrop-filter: blur(10px);
      color: #fff;
      box-shadow: 0 4px 15px rgba(0,0,0,0.4);
      animation: fadeIn 0.8s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    h2 {
      text-align: center; margin-bottom: 20px;
      font-size: 24px; color: #2ecc71;
    }
    label { display: block; margin: 10px 0 5px; font-weight: 500; }
    input {
      width: 100%; padding: 12px; margin-bottom: 15px;
      border: none; border-radius: 8px;
      background: rgba(255,255,255,0.1); color: #fff;
      outline: none; font-size: 14px;
      transition: all 0.3s ease-in-out;
    }
    input:focus {
      background: rgba(255,255,255,0.2);
      border: 1px solid #2ecc71;
    }
    button {
      width: 100%; padding: 12px;
      background: #2ecc71; color: #fff;
      border: none; border-radius: 8px;
      cursor: pointer; font-size: 16px;
      transition: background 0.3s ease-in-out;
    }
    button:hover { background: #27ae60; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Register for <?php echo htmlspecialchars($event['name']); ?></h2>
    <form method="POST">
      <label>Full Name</label>
      <input type="text" name="name" required>
      
      <label>Email</label>
      <input type="email" name="email" required>
      
      <label>Phone</label>
      <input type="text" name="phone" required>
      
      <label>Roll Number</label>
      <input type="text" name="roll" required>
      
      <label>College Name</label>
      <input type="text" name="college" required>
      
      <button type="submit">Register</button>
    </form>
  </div>
</body>
</html>
