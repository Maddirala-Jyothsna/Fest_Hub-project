<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Event - FestHub</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                  url('../assets/images/bg.jpg') no-repeat center center/cover;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: #fff;
    }

    .form-container {
      background: rgba(255, 255, 255, 0.12);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      padding: 30px;
      width: 420px;
      max-height: 90vh;   /* 👈 prevents overflowing */
      overflow-y: auto;   /* 👈 allows inner scroll only */
      box-shadow: 0 8px 32px rgba(0,0,0,0.4);
      animation: fadeIn 1s ease-in-out;
    }

    .form-container h2 {
      text-align: center;
      margin-bottom: 20px;
      font-size: 26px;
      color: #fff;
    }

    .form-container label {
      display: block;
      margin-bottom: 6px;
      font-size: 14px;
      font-weight: 600;
      color: #ffffff;   /* 👈 bright white */
    }

    .form-container input,
    .form-container textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 10px;
      border: 1px solid rgba(255, 255, 255, 0.3);
      outline: none;
      background: rgba(255, 255, 255, 0.15);
      color: #fff;
      font-size: 14px;
      transition: all 0.3s ease;
    }

    .form-container input:focus,
    .form-container textarea:focus {
      border-color: #00c6ff;
      box-shadow: 0 0 8px rgba(0,198,255,0.6);
    }

    .form-container input[type="file"] {
      padding: 5px;
      background: transparent;
    }

    .form-container button {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 12px;
      background: linear-gradient(135deg, #00c6ff, #0072ff);
      color: #fff;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }

    .form-container button:hover {
      background: linear-gradient(135deg, #0072ff, #00c6ff);
      transform: scale(1.03);
    }

    .form-container a {
      display: block;
      text-align: center;
      margin-top: 15px;
      color: #ddd;
      font-size: 14px;
      text-decoration: none;
    }

    .form-container a:hover {
      color: #00c6ff;
      text-decoration: underline;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Scrollbar styling */
    .form-container::-webkit-scrollbar {
      width: 6px;
    }
    .form-container::-webkit-scrollbar-thumb {
      background: #00c6ff;
      border-radius: 10px;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Add Event</h2>
    <form method="POST" action="addevent_action.php" enctype="multipart/form-data">
      <label>Event Name</label>
      <input type="text" name="name" required>
      <label>College Name</label>
      <input type="text" name="college_name" >

      <label>Details</label>
      <textarea name="details" rows="3" required></textarea>

      <label>Category</label>
      <input type="text" name="category">

      <label>Date</label>
      <input type="date" name="event_date">

      <label>Location</label>
      <input type="text" name="location">

      <label>Participants</label>
      <input type="number" name="participants">

      <label>Price</label>
      <input type="text" name="price">

      <label>Organizers</label>
      <input type="text" name="organizer">
  

      <label>Poster</label>
      <input type="file" name="poster">

      <button type="submit" name="submit">Add Event</button>
    </form>
    <a href="dashboard.php">⬅ Back to Dashboard</a>
  </div>
</body>
</html>
