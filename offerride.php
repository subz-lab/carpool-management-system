//Offerride.php

<?php include 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $from = trim($_POST['from']);
  $to = trim($_POST['to']);
  $date = $_POST['date'];
  $time = $_POST['time'];
  $seats = (int)$_POST['seats'];

  $stmt = $db->prepare('
    INSERT INTO rides (driver_id, from_location, to_location, date, time, seats)
    VALUES (:driver_id, :from, :to, :date, :time, :seats)
  ');
  $stmt->bindValue(':driver_id', $_SESSION['user_id'], SQLITE3_INTEGER);
  $stmt->bindValue(':from', $from, SQLITE3_TEXT);
  $stmt->bindValue(':to', $to, SQLITE3_TEXT);
  $stmt->bindValue(':date', $date, SQLITE3_TEXT);
  $stmt->bindValue(':time', $time, SQLITE3_TEXT);
  $stmt->bindValue(':seats', $seats, SQLITE3_INTEGER);
  
  if ($stmt->execute()) {
    header('Location: profile.php');
    exit();
  } else {
    die("Failed to offer ride!");
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Poolmate - Offer Ride</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <!-- Same header as index.php -->
  </header>

  <main>
    <section class="form-container">
      <h2>Offer a Ride</h2>
      <form method="POST" action="offerride.php">
        <label for="from">From</label>
        <input type="text" id="from" name="from" required>

        <label for="to">To</label>
        <input type="text" id="to" name="to" required>

        <label for="date">Date</label>
        <input type="date" id="date" name="date" required>

        <label for="time">Time</label>
        <input type="time" id="time" name="time" required>

        <label for="seats">Available Seats</label>
        <input type="number" id="seats" name="seats" min="1" max="10" required>

        <button type="submit" class="btn">Submit Ride</button>
      </form>
    </section>
  </main>

  <footer>
    <!-- Same footer as index.php -->
  </footer>
  <script src="js/script.js"></script>
</body>
</html>