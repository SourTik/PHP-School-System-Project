<?php
session_start();
include('db.php');

if (isset($_GET['id'])) {
    $subject_id = $_GET['id'];

    // Fetch the subject to update
    $sql = 'SELECT * FROM subjects WHERE subject_id = :subject_id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':subject_id', $subject_id);
    $stmt->execute();
    $subject = $stmt->fetch();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $subject_name = $_POST['subject_name'];

        // Validation
        if (empty($subject_name)) {
            $_SESSION['error'] = 'Subject name is required.';
        } else {
            // Update the subject in the database
            $update_sql = 'UPDATE subjects SET subject_name = :subject_name WHERE subject_id = :subject_id';
            $stmt = $conn->prepare($update_sql);
            $stmt->bindParam(':subject_name', $subject_name);
            $stmt->bindParam(':subject_id', $subject_id);
            $stmt->execute();

            $_SESSION['success'] = 'Subject updated successfully.';
            header('Location: subjects.php');
            exit();
        }
    }
} else {
    $_SESSION['error'] = 'Invalid subject ID.';
    header('Location: subjects.php');
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Subject</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h3>Update Subject</h3>
        
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $subject_id; ?>" method="post">
            <div class="mb-3">
                <label for="subject_name" class="form-label">Subject Name</label>
                <input type="text" class="form-control" id="subject_name" name="subject_name" value="<?php echo htmlspecialchars($subject['subject_name']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Subject</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
