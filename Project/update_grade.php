<?php
session_start();
include('db.php');
include('base.php');

$grade_id = $_GET['id'] ?? null;
$error = '';

if (!$grade_id) {
    header('Location: grades_form.php');
    exit();
}

// Get current grade
$sql = 'SELECT * FROM grades WHERE grade_id = :grade_id';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':grade_id', $grade_id);
$stmt->execute();
$grade = $stmt->fetch();

if (!$grade) {
    $error = 'Grade not found!';
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $grade_name = $_POST['grade_name'];
        if (!empty($grade_name)) {
            $sql = 'UPDATE grades SET grade_name = :grade_name WHERE grade_id = :grade_id';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':grade_name', $grade_name);
            $stmt->bindParam(':grade_id', $grade_id);
            $stmt->execute();
            $_SESSION['success'] = 'Grade updated successfully!';
            header('Location: grades_form.php');
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Grade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Update Grade</h2>

            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form action="update_grade.php?id=<?php echo $grade['grade_id']; ?>" method="post">
                <div class="mb-3">
                    <label for="grade_name" class="form-label">Grade Name</label>
                    <input type="text" name="grade_name" id="grade_name" class="form-control" value="<?php echo $grade['grade_name']; ?>" required>
                </div>
                <button type="submit" class="btn btn-warning w-100">Update Grade</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
