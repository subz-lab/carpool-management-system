//bookride.php

<?php include 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ride_id'])) {
  $rideId = (int)$_POST['ride_id'];
  $passengerId = $_SESSION['user_id'];

  try {
    // Check seat availability
    $rideStmt = $db->prepare('SELECT seats FROM rides WHERE id = :ride_id');
    $rideStmt->bindValue(':ride_id', $rideId, SQLITE3_INTEGER);
    $rideResult = $rideStmt->execute();
    $ride = $rideResult->fetchArray(SQLITE3_ASSOC);

    if (!$ride || $ride['seats'] < 1) die("Ride no longer available!");

    // Start transaction
    $db->exec('BEGIN TRANSACTION');

    // Create booking
    $bookStmt = $db->prepare('
      INSERT INTO bookings (ride_id, passenger_id)
      VALUES (:ride_id, :passenger_id)
    ');
    $bookStmt->bindValue(':ride_id', $rideId, SQLITE3_INTEGER);
    $bookStmt->bindValue(':passenger_id', $passengerId, SQLITE3_INTEGER);
    $bookStmt->execute();

    // Update seats
    $updateStmt = $db->prepare('
      UPDATE rides SET seats = seats - 1
      WHERE id = :ride_id
    ');
    $updateStmt->bindValue(':ride_id', $rideId, SQLITE3_INTEGER);
    $updateStmt->execute();

    // Commit
    $db->exec('COMMIT');

    header('Location: profile.php');
    exit();
  } catch (Exception $e) {
    $db->exec('ROLLBACK');
    die("Booking failed: " . $e->getMessage());
  }
}

header('Location: findride.php');
?>