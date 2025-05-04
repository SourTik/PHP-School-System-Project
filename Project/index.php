<?php
include('db.php');
include('base.php');

// Fetch students with grades, date of birth, and gender
$sql = 'SELECT students.*, grades.grade_name FROM students LEFT JOIN grades ON students.grade_id = grades.grade_id';
$stmt = $conn->prepare($sql);
$stmt->execute();
$students = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students - School Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-4">
    <h2 class="text-center mb-4">Students</h2>

    <!-- Add Student Button -->
    <a href="form.php" class="btn btn-success mb-3">Add Student</a>

    <!-- Students Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Grade</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo $student['student_id']; ?></td>
                    <td><?php echo $student['first_name']; ?></td>
                    <td><?php echo $student['last_name']; ?></td>
                    <td><?php echo $student['gender']; ?></td>
                    <td><?php echo $student['date_of_birth']; ?></td>
                    <td><?php echo $student['grade_name']; ?></td>
                    <td>
                        <a href="update_student.php?id=<?php echo $student['student_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_student.php?id=<?php echo $student['student_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
