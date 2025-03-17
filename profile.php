<?php 
include 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch user details
$stmt = $db->prepare('SELECT * FROM users WHERE id = :id');
$stmt->bindValue(':id', $_SESSION['user_id'], SQLITE3_INTEGER);
$user = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

// Fetch offered rides
$ridesStmt = $db->prepare('SELECT * FROM rides WHERE driver_id = :driver_id ORDER BY date DESC');
$ridesStmt->bindValue(':driver_id', $_SESSION['user_id'], SQLITE3_INTEGER);
$ridesResult = $ridesStmt->execute();

// Fetch booked rides
$bookingsStmt = $db->prepare('
    SELECT rides.* FROM bookings
    JOIN rides ON bookings.ride_id = rides.id
    WHERE bookings.passenger_id = :passenger_id
    ORDER BY date DESC
');
$bookingsStmt->bindValue(':passenger_id', $_SESSION['user_id'], SQLITE3_INTEGER);
$bookingsResult = $bookingsStmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Poolmate</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title">Profile Information</h3>
                        <div class="mb-3">
                            <strong>Name:</strong> <?= htmlspecialchars($user['name']) ?>
                        </div>
                        <div class="mb-3">
                            <strong>Email:</strong> <?= htmlspecialchars($user['email']) ?>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title mb-4">Your Offered Rides</h3>
                        <?php if($ridesResult->fetchArray() === false): ?>
                            <p class="text-muted">No rides offered yet.</p>
                        <?php else: ?>
                            <?php while ($ride = $ridesResult->fetchArray(SQLITE3_ASSOC)): ?>
                                <div class="mb-4 p-3 border rounded">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5><?= htmlspecialchars($ride['from_location']) ?> → <?= htmlspecialchars($ride['to_location']) ?></h5>
                                            <p class="mb-1"><?= date('M j, Y', strtotime($ride['date'])) ?> at <?= date('g:i A', strtotime($ride['time'])) ?></p>
                                            <p class="mb-0">Seats Available: <?= $ride['seats'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card shadow mt-4">
                    <div class="card-body">
                        <h3 class="card-title mb-4">Your Booked Rides</h3>
                        <?php if($bookingsResult->fetchArray() === false): ?>
                            <p class="text-muted">No rides booked yet.</p>
                        <?php else: ?>
                            <?php while ($ride = $bookingsResult->fetchArray(SQLITE3_ASSOC)): ?>
                                <div class="mb-4 p-3 border rounded">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5><?= htmlspecialchars($ride['from_location']) ?> → <?= htmlspecialchars($ride['to_location']) ?></h5>
                                            <p class="mb-1"><?= date('M j, Y', strtotime($ride['date'])) ?> at <?= date('g:i A', strtotime($ride['time'])) ?></p>
                                            
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>