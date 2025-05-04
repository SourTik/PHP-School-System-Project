<?php
session_start(); // Ensure session is started here
include('db.php');  // Include the database connection
$empty_err = $username_err = $password_err = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $empty_err = 'Both fields are required.';
    } else {
        $sql = 'SELECT * FROM users WHERE username = :username';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to home.php
            header('Location: home.php');
            exit();
        } else {
            $username_err = 'Invalid username or password';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management System - Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<?php include('base.php'); // Include the navbar here if needed ?>

<body>
<header class="bg-success text-white py-3 mb-4">
    <div class="container text-center">
        <h1>Login to School Management System</h1>
        <p class="lead">Access the system by logging in with your credentials.</p>
    </div>
</header>
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4 shadow-lg">
                <h2 class="text-center mb-4">Login</h2>
                <form action="login.php" method="post" class="form-group">
                    <div class="mb-3">
                        <small class="text-danger"><?= $empty_err ?></small>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                        <small class="text-danger"><?= $username_err ?></small>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        <small class="text-danger"><?= $password_err ?></small>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Login</button>
                </form>
                <p class="mt-3 text-center">Don't have an account? <a href="signup.php">Sign up here</a>.</p>
            </div>
        </div>
    </div>
</div>
<footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2025 School Management System. All rights reserved.</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
