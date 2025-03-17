//findride.php

<?php include 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit();
}

// Fetch available rides
$rides = $db->query('
  SELECT rides.*, users.name AS driver_name
  FROM rides
  JOIN users ON rides.driver_id = users.id
  WHERE seats > 0
');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Poolmate - Find Ride</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <!-- Same header as index.php -->
  </header>

  <main>
    <section class="form-container">
      <h2>Available Rides</h2>
      <div id="results">
        <?php while ($ride = $rides->fetchArray(SQLITE3_ASSOC)): ?>
          <div class="ride-card">
            <h3><?= htmlspecialchars($ride['from_location']) ?> → <?= htmlspecialchars($ride['to_location']) ?></h3>
            <p>Driver: <?= htmlspecialchars($ride['driver_name']) ?></p>
            <p>Date: <?= $ride['date'] ?> at <?= $ride['time'] ?></p>
            <p>Seats Available: <?= $ride['seats'] ?></p>
            <form method="POST" action="bookride.php">
              <input type="hidden" name="ride_id" value="<?= $ride['id'] ?>">
              <button type="submit" class="btn">Book Ride</button>
            </form>
          </div>
        <?php endwhile; ?>
      </div>
    </section>
  </main>

  <footer>
    <!-- Same footer as index.php -->
  </footer>
  <script src="js/script.js"></script>
</body>
</html>