<!doctype html>
<html lang="en">

<?php
include('base.php');
include('db.php');

$empty_err = $first_name_err = $last_name_err = $dob_err = $gender_err = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];

    // Validation
    if (empty($first_name) || empty($last_name) || empty($date_of_birth) || empty($gender)) {
        $empty_err = 'All fields are required.';
    }

    if (empty($empty_err)) {
        // Insert new student into the database (grade_id is auto-generated)
        $sql = 'INSERT INTO students (first_name, last_name, date_of_birth, gender) 
                VALUES (:first_name, :last_name, :date_of_birth, :gender)';
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':date_of_birth', $date_of_birth);
            $stmt->bindParam(':gender', $gender);
            $stmt->execute();
            header('Location: index.php');
            exit();
        } catch (PDOException $e) {
            echo 'Insertion failed: ' . $e->getMessage();
        }
    }
}
?>

<body>
<div class="container">
    <h2 class="text-center mt-4">Add New Student</h2>
    <form action="form.php" method="post">
        <div class="mb-3">
            <small class="text-danger"><?= $empty_err ?></small>
        </div>

        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" required>
            <small class="text-danger"><?= $first_name_err ?></small>
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control" required>
            <small class="text-danger"><?= $last_name_err ?></small>
        </div>

        <div class="mb-3">
            <label for="date_of_birth" class="form-label">Date of Birth</label>
            <input type="date" name="date_of_birth" class="form-control" required>
            <small class="text-danger"><?= $dob_err ?></small>
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select name="gender" class="form-control" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
            <small class="text-danger"><?= $gender_err ?></small>
        </div>

        <button type="submit" class="btn btn-primary w-100">Add Student</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
