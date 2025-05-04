<?php
session_start();
include('db.php');

if (!isset($_GET['id'])) {
    header('Location: index.php'); // If no student ID is provided, redirect to the student list.
    exit();
}

$id = $_GET['id'];
$sql = 'SELECT * FROM students WHERE student_id = :id';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$student = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $grade_id = $_POST['grade_id'];

    $sql = 'UPDATE students SET first_name = :first_name, last_name = :last_name, date_of_birth = :date_of_birth, gender = :gender, grade_id = :grade_id WHERE student_id = :id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':date_of_birth', $date_of_birth);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':grade_id', $grade_id);
    $stmt->execute();

    $_SESSION['message'] = 'Student updated successfully!';
    header('Location: index.php'); // Redirect back to student list after update
    exit();
}
?>

<!-- update_student.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Update Student</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $student['first_name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $student['last_name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="date_of_birth" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?php echo $student['date_of_birth']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-control" id="gender" name="gender">
                    <option value="Male" <?php echo $student['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo $student['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="grade_id" class="form-label">Grade</label>
                <select class="form-control" id="grade_id" name="grade_id" required>
                    <?php
                    // Fetch grades to populate the dropdown
                    $grades_sql = 'SELECT * FROM grades';
                    $grades_stmt = $conn->prepare($grades_sql);
                    $grades_stmt->execute();
                    while ($grade = $grades_stmt->fetch()) {
                        echo "<option value=\"{$grade['grade_id']}\" " . ($student['grade_id'] == $grade['grade_id'] ? 'selected' : '') . ">{$grade['grade_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Student</button>
        </form>
    </div>
</body>
</html>
