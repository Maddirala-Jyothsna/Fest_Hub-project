<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include("../database/config.php");
$result = $conn->query("SELECT * FROM reviews ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Reviews - Admin</title>
  <style>
    body { font-family: "Poppins", sans-serif; background:#f9f9f9; }
    .container { max-width: 800px; margin: 40px auto; }
    .review-card {
      background: #fff;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 15px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      position: relative;
    }
    .review-card h3 { margin: 0; font-size: 18px; }
    .review-card small { color: #666; }
    .delete-btn {
      position: absolute;
      top: 15px;
      right: 15px;
      background: #e63946;
      color: #fff;
      border: none;
      padding: 6px 12px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
      transition: background 0.3s;
    }
    .delete-btn:hover {
      background: #b71c1c;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Event Reviews</h2>
    <?php while($row = $result->fetch_assoc()) { ?>
      <div class="review-card">
        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
        <small><?php echo htmlspecialchars($row['email']); ?> | <?php echo htmlspecialchars($row['phone']); ?></small>
        <p><?php echo htmlspecialchars($row['message']); ?></p>
        
        <!-- Delete Form -->
        <form action="delete_review.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');">
          <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
          <button type="submit" class="delete-btn">Delete</button>
        </form>
      </div>
    <?php } ?>
  </div>
</body>
</html>
