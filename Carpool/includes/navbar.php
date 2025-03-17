<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">Poolmate</a>
        
        <div class="d-flex align-items-center">
            <?php if(isset($_SESSION['user_id'])): ?>
                <span class="text-light me-3">Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
                <a href="profile.php" class="btn btn-light me-2">Profile</a>
                <a href="logout.php" class="btn btn-outline-light">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-light me-2">Login</a>
                <a href="register.php" class="btn btn-outline-light">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>