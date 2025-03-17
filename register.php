<?php include 'includes/config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Poolmate</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">Create Account</h2>
                        
                        <?php if(isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>

                        <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email address</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="confirmPassword" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Register</button>
                        </form>

                        <div class="mt-3 text-center">
                            Already have an account? <a href="login.php" class="text-decoration-none">Login here</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        if ($password !== $confirmPassword) {
            $_SESSION['error'] = "Passwords do not match!";
            header('Location: register.php');
            exit();
        }

        try {
            $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
            $stmt->bindValue(':email', $email, SQLITE3_TEXT);
            $result = $stmt->execute();
            
            if ($result->fetchArray()) {
                $_SESSION['error'] = "Email already exists!";
                header('Location: register.php');
                exit();
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
            $stmt->bindValue(':name', $name, SQLITE3_TEXT);
            $stmt->bindValue(':email', $email, SQLITE3_TEXT);
            $stmt->bindValue(':password', $hashedPassword, SQLITE3_TEXT);
            
            if ($stmt->execute()) {
                $_SESSION['success'] = "Registration successful! Please login.";
                header('Location: login.php');
                exit();
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Registration failed: " . $e->getMessage();
            header('Location: register.php');
            exit();
        }
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>