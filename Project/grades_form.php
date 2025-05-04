<?php
session_start();
include('db.php');
include('base.php');

// Add Grade
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_grade'])) {
    $grade_name = $_POST['grade_name'];

    if (!empty($grade_name)) {
        $sql = "INSERT INTO grades (grade_name) VALUES (:grade_name)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':grade_name', $grade_name);
        $stmt->execute();
        $_SESSION['success'] = "Grade added successfully!";
    }
}

// Get all grades
$sql = "SELECT * FROM grades";
$stmt = $conn->prepare($sql);
$stmt->execute();
$grades = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grades Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="text-center mb-4">Manage Grades</h2>

            <!-- Success Message -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <!-- Add Grade Form -->
            <form action="grades_form.php" method="post" class="form-group">
                <div class="mb-3">
                    <label for="grade_name" class="form-label">Grade Name (e.g., A+, B-)</label>
                    <input type="text" name="grade_name" id="grade_name" class="form-control" required>
                </div>
                <button type="submit" name="add_grade" class="btn btn-success">Add Grade</button>
            </form>

            <!-- Grades Table -->
            <h3 class="mt-5">Existing Grades</h3>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Grade ID</th>
                        <th>Grade Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($grades as $grade): ?>
                        <tr>
                            <td><?php echo $grade['grade_id']; ?></td>
                            <td><?php echo $grade['grade_name']; ?></td>
                            <td>
                                <a href="update_grade.php?id=<?php echo $grade['grade_id']; ?>" class="btn btn-warning btn-sm">Update</a>
                                <a href="delete_grade.php?id=<?php echo $grade['grade_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
