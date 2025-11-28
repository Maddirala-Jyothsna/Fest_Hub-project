<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include("../database/config.php");

// Get event by ID safely
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid event ID");
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM events WHERE id = $id");

if ($result->num_rows === 0) {
    die("Event not found");
}
$event = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Event</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: url('../assets/images/bg.jpg') no-repeat center center/cover;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: flex-start; /* align to top */
      padding: 40px 0;
      overflow-y: auto;
    }

    .form-container {
      background: rgba(255, 255, 255, 0.97);
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.25);
      width: 420px;
      max-width: 95%;
      animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .form-container h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #222;
      font-size: 24px;
      animation: slideDown 0.8s ease-in-out;
    }

    @keyframes slideDown {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .form-container label {
      display: block;
      margin-top: 14px;
      font-weight: 600;
      color: #333;
      font-size: 14px;
      opacity: 0.9;
      transition: color 0.3s ease;
    }

    .form-container input,
    .form-container textarea,
    .form-container button {
      width: 100%;
      padding: 12px;
      margin-top: 6px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 15px;
      transition: all 0.3s ease;
    }

    .form-container input:focus,
    .form-container textarea:focus {
      outline: none;
      border-color: #ff9800;
      box-shadow: 0 0 10px rgba(255, 152, 0, 0.4);
    }

    .form-container textarea {
      min-height: 100px;
      resize: vertical;
    }

    .form-container button {
      background: #ff9800;
      color: white;
      font-weight: bold;
      border: none;
      cursor: pointer;
      margin-top: 20px;
      transition: transform 0.2s ease, background 0.3s ease;
    }

    .form-container button:hover {
      background: #e68900;
      transform: scale(1.05);
    }

    .poster-preview {
      display: block;
      margin: 12px auto;
      max-width: 140px;
      border-radius: 8px;
      transition: transform 0.3s ease;
    }

    .poster-preview:hover {
      transform: scale(1.08);
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Edit Event</h2>
    <form action="editevent_action.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $id; ?>">

      <label for="name">Event Name</label>
      <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($event['name']); ?>" required>

      <label for="college_name">College Name</label>
      <input type="text" id="college_name" name="college_name" value="<?php echo htmlspecialchars($event['college_name']); ?>" required>

      <label for="category">Category</label>
      <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($event['category']); ?>">

      <label for="event_date">Event Date</label>
      <input type="date" id="event_date" name="event_date" value="<?php echo $event['event_date']; ?>">

      <label for="location">Location</label>
      <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($event['location']); ?>">

      <label for="participants">Participants</label>
      <input type="number" id="participants" name="participants" value="<?php echo $event['participants']; ?>">

      <label for="price">Price</label>
      <input type="number" step="0.01" id="price" name="price" value="<?php echo $event['price']; ?>">

      <label for="organizer">Organizer</label>
      <input type="text" id="organizer" name="organizer" value="<?php echo htmlspecialchars($event['organizer']); ?>">

      <label for="details">Event Details</label>
      <textarea id="details" name="details" rows="4" required><?php echo htmlspecialchars($event['details']); ?></textarea>

      <label>Event Poster</label>
      <img src="../<?php echo $event['poster']; ?>" class="poster-preview" alt="Event Poster">
      <input type="file" name="poster">

      <button type="submit" name="update">Update Event</button>
    </form>
  </div>
</body>
</html>
