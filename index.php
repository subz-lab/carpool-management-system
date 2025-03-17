//index.php

<?php include 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Poolmate - Home</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <nav>
      <div class="logo">
        <a href="index.php">Poolmate</a>
      </div>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
        <li><a href="offerride.php">Offer Ride</a></li>
        <li><a href="findride.php">Find Ride</a></li>
        <li><a href="profile.php">Profile</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section class="hero">
      <h1>Welcome to Poolmate</h1>
      <p>Your smart solution for carpooling. Save money, reduce traffic, and help the environment.</p>
      <a href="register.php" class="btn">Join Now</a>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 Poolmate. All rights reserved.</p>
  </footer>
  <script src="js/script.js"></script>
</body>
</html>