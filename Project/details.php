<!DOCTYPE html>
<html lang="en">
<?php
include('db.php');
include('base.php');

$id = $_GET['id'];

$sql = 'SELECT * FROM students WHERE student_id = :id';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$student = $stmt->fetch();
?>
<body>
<div class="container">
    <div class="row flex justify-content-center m-4">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <div class="display-6 text-center">
                        Student Details
                    </div>
                    <p>
                        <strong>First Name: </strong> <?php echo htmlspecialchars($student['first_name']); ?>
                    </p>
                    <p>
                        <strong>Last Name: </strong> <?php echo htmlspecialchars($student['last_name']); ?>
                    </p>
                    <p>
                        <strong>Date of Birth: </strong> <?php echo htmlspecialchars($student['date_of_birth']); ?>
                    </p>
                    <p>
                        <strong>Gender: </strong> <?php echo htmlspecialchars($student['gender']); ?>
                    </p>
                    <p>
                        <strong>Grade: </strong> <?php echo htmlspecialchars($student['grade_id']); ?>
                    </p>
                    <div class="text-center p-3">
                        <a href="update_student.php?id=<?php echo $student['student_id']; ?>" class="btn btn-primary">Update</a>
                        <a href="delete_student.php?id=<?php echo $student['student_id']; ?>" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
