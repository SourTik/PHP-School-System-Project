<?php
session_start();
include('db.php');

if (!isset($_GET['id'])) {
    header('Location: index_teachers.php'); // If no teacher ID is provided, redirect to the teacher list.
    exit();
}

$id = $_GET['id'];
$sql = 'SELECT * FROM teachers WHERE teacher_id = :id';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$teacher = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $subject_id = $_POST['subject_id'];

    $sql = 'UPDATE teachers SET first_name = :first_name, last_name = :last_name, subject_id = :subject_id WHERE teacher_id = :id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':subject_id', $subject_id);
    $stmt->execute();

    $_SESSION['message'] = 'Teacher updated successfully!';
    header('Location: index_teachers.php'); // Redirect back to teacher list after update
    exit();
}
?>

<!-- update_teacher.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Teacher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Update Teacher</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $teacher['first_name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $teacher['last_name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="subject_id" class="form-label">Subject</label>
                <select class="form-control" id="subject_id" name="subject_id" required>
                    <?php
                    // Fetch subjects to populate the dropdown
                    $subjects_sql = 'SELECT * FROM subjects';
                    $subjects_stmt = $conn->prepare($subjects_sql);
                    $subjects_stmt->execute();
                    while ($subject = $subjects_stmt->fetch()) {
                        echo "<option value=\"{$subject['subject_id']}\" " . ($teacher['subject_id'] == $subject['subject_id'] ? 'selected' : '') . ">{$subject['subject_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Teacher</button>
        </form>
    </div>
</body>
</html>
