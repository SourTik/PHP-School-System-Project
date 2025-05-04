<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management System - Sign Up</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<?php
include('base.php'); // Assume common elements like header/meta are here
include('db.php');

$empty_err = $username_err = $email_err = $password_err = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $pattern = '/^[a-zA-Z0-9]{3,20}$/';

    if (empty($username) || empty($email) || empty($password)) {
        $empty_err = 'All fields are required.';
    } else {
        if (!preg_match($pattern, $username)) {
            $username_err = 'Your username is not valid.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = 'Your email is not valid.';
        }
        if (!preg_match($pattern, $password)) {
            $password_err = 'Your password is not valid.';
        }
        if (empty($username_err) && empty($email_err) && empty($password_err)) {
            $sql = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
            $stmt->execute();
            header('Location: login.php');
            exit();
        }
    }
}
?>
<body>
<header class="bg-success text-white py-3 mb-4">
    <div class="container text-center">
        <h1>Sign Up for School Management System</h1>
        <p class="lead">Create your account to access the system.</p>
    </div>
</header>
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4 shadow-lg">
                <h2 class="text-center mb-4">Sign Up</h2>
                <form action="signup.php" method="post" class="form-group">
                    <div class="mb-3">
                        <small class="text-danger"><?= $empty_err ?></small>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                        <small class="text-danger"><?= $username_err ?></small>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" name="email" id="email" class="form-control" required>
                        <small class="text-danger"><?= $email_err ?></small>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        <small class="text-danger"><?= $password_err ?></small>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Sign Up</button>
                </form>
                <p class="mt-3 text-center">Already have an account? <a href="login.php">Login here</a>.</p>
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
