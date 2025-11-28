<?php 
include __DIR__ . '/../database/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>colorido- College Events</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
    body { background: #f0f4f8; color: #333; line-height: 1.6; transition: background 1s ease-in-out; }

    /* FIX stray button */
    body > button { display:none !important; }

    body.scrolled-bg {
      background: url('../assets/images/start_main1.jpg') no-repeat center/cover fixed;
    }

    /* College Header */
    .college-header {
      background: #fff;
      border-bottom: 3px solid #ff6b35;
      text-align: center;
      padding: 15px 20px;
      position: relative;
    }
    .college-header img { height: 100px; width: 100px; vertical-align: middle; margin-right: 10px; }
    .college-header h1 { font-size: 50px; font-weight: 700; color: #a2130bff; display:inline-block; vertical-align:middle; }
    .college-header p { font-size: 25px; margin-top: 5px; }
    .badge { display:inline-block; padding:6px 14px; border-radius:20px; margin:0 4px; background:#1976d2; color:#fff; }
    .badge.green { background:#2e7d32; }

    /* Navbar */
    .header { display:flex; justify-content:space-between; align-items:center; padding:20px 50px; background: linear-gradient(135deg,#1e3c72,#2a5298); color:#fff; position:sticky; top:0; z-index:100; }
    .header .logo { font-size:28px; font-weight:600; }
    .header .logo span { color:#ff9526; }
    .header nav ul { display:flex; list-style:none; gap:25px; }
    .header nav ul li a { color:#fff; text-decoration:none; }
    .btn-login { background:#ff6b35; color:#fff; padding:10px 20px; border-radius:30px; text-decoration:none; }

    /* Hero */
    .hero {
      position: relative;
      background: url('../assets/images/start_main1.jpg') no-repeat center center/cover;
      height: 90vh;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      color: #fff;
    }
    .hero::before {
      content: "";
      position: absolute;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      top:0; left:0;
      z-index:1;
    }
    .hero-overlay { position:relative; z-index:2; }

    /* Categories */
    .categories { text-align:center; padding:60px 20px; }
    .filters { display:inline-flex; gap:12px; }
    .filters button {
      padding:10px 20px; border:none; border-radius:25px;
      background:#e0e0e0; cursor:pointer;
    }
    .filters .active { background:#1e3c72; color:#fff; }

    /* Events */
    .event-container {
      display:grid;
      grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
      gap:30px;
      padding:30px 50px;
    }

    .event-card {
      background:#fff;
      border-radius:15px;
      box-shadow:0 8px 25px rgba(0,0,0,0.08);
      overflow:hidden;
      transition:0.3s;
    }
    .event-card:hover { transform:translateY(-5px); }

    /* ⭐ FIX ADDED BELOW */
    .event-img {
        position: relative;   /* FIX: tag stays inside card */
    }

    .event-img img {
      width:100%; height:200px; object-fit:cover;
    }

    .tag {
      position:absolute;
      top:12px; left:12px;
      background:#ff6b35;
      color:#fff;
      padding:6px 12px;
      border-radius:6px;
      font-size:14px;
    }

    .event-info { padding:20px; }
    .event-info h3 { font-size:22px; margin-bottom:10px; }

    footer { padding:30px; margin-top:60px; background:linear-gradient(135deg,#1e3c72,#2a5298); color:#fff; text-align:center; }
  </style>
</head>

<body>

  <!-- College Header -->
  <div class="college-header">
    <img src="../assets/images/rvrlogo.jpeg">
    <h1>R.V.R. & J.C. COLLEGE OF ENGINEERING</h1>
    <p>(AUTONOMOUS) | EAPCET Code: RVJC<br>Affiliated to ANU</p>
    <div class="badges">
      <div class="badge">NBA</div>
      <div class="badge green">NAAC A+</div>
    </div>
  </div>

  <!-- Navbar -->
  <header class="header">
    <div class="logo">Colorido <span>Events</span></div>
    <nav>
      <ul>
        <li><a href="#events">Events</a></li>
        <li><a href="contact.html">Contact</a></li>
      </ul>
    </nav>
    <a href="login.html" class="btn-login">Admin Login</a>
  </header>

  <!-- Hero -->
  <section class="hero">
    <div class="hero-overlay">
      <h1>COLORIDO<span>2K25</span></h1>
      <p>Explore, register, and be part of amazing events around you.</p>
    </div>
  </section>

  <!-- Categories -->
  <section class="categories">
    <h2>Upcoming Events</h2>
    <p>Filter by category:</p>
    <div class="filters">
      <button class="active">All</button>
      <button>Technology</button>
      <button>Cultural</button>
      <button>Sports</button>
      <button>Arts</button>
    </div>
  </section>

  <!-- Events -->
  <div class="event-container" id="events">
    <?php
    $sql = "SELECT * FROM events ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
    ?>
      <div class="event-card" data-category="<?php echo strtolower($row['category']); ?>">
        <div class="event-img">
          <img src="../<?php echo $row['poster']; ?>">
          <span class="tag"><?php echo $row['category']; ?></span>
        </div>
        <div class="event-info">
          <h3><?php echo $row['name']; ?></h3>
          <p><?php echo $row['details']; ?></p>
          <ul>
            <li>🏫 <?php echo $row['college_name']; ?></li>
            <li>📅 <?php echo $row['event_date']; ?></li>
            <li>📍 <?php echo $row['location']; ?></li>
            <li>👥 Max <?php echo $row['participants']; ?> participants</li>
            <li>💰 <?php echo $row['price']; ?></li>
          </ul>
          <div class="organizer">👤 Organizer: <?php echo $row['organizer']; ?></div>
          <a href="register.php?event_id=<?php echo $row['id']; ?>" class="btn">Register</a>
        </div>
      </div>
    <?php
      }
    } else {
      echo "<p style='text-align:center;'>No events available yet.</p>";
    }
    ?>
  </div>

  <!-- Footer -->
  <footer>
    <p>© 2025 FestHub | Designed for College Events</p>
  </footer>

  <!-- Filters JS -->
  <script>
    const filterButtons = document.querySelectorAll('.filters button');
    const eventContainer = document.getElementById('events');
    const allCards = Array.from(document.querySelectorAll('.event-card'));

    filterButtons.forEach(button => {
      button.addEventListener('click', () => {
        filterButtons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');

        const filter = button.textContent.toLowerCase();
        eventContainer.innerHTML = "";

        if (filter === "all") {
          allCards.forEach(card => eventContainer.appendChild(card));
        } else {
          allCards.forEach(card => {
            if (card.dataset.category === filter) eventContainer.appendChild(card);
          });
        }
      });
    });
  </script>

  <!-- BACKGROUND CHANGE AFTER SCROLL -->
  <script>
    window.addEventListener("scroll", () => {
      if (window.scrollY > 150) {
        document.body.classList.add("scrolled-bg");
      } else {
        document.body.classList.remove("scrolled-bg");
      }
    });
  </script>

</body>
</html>
