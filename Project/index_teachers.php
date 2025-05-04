<?php
session_start();
include('db.php');
include('base.php');  // Include base.php for consistent navbar and other base code

// Fetch all teachers
$sql = 'SELECT * FROM teachers';
$stmt = $conn->prepare($sql);
$stmt->execute();
$teachers = $stmt->fetchAll();
?>

<!doctype html>
<html lang="en">
  <body>
    <div class="container">
        <div class="row justify-content-center m-4">
            <div class="col-12">
                <div class="display-6 text-center">Teachers List</div>
                <a href="teachers_form.php" class="btn btn-primary mb-3">Add New Teacher</a>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Subject</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($teachers as $teacher) : ?>
                            <tr>
                                <td><?php echo $teacher['first_name']; ?></td>
                                <td><?php echo $teacher['last_name']; ?></td>
                                <td>
                                    <?php
                                    $subject_id = $teacher['subject_id'];
                                    // Fetch the subject name from the subjects table
                                    $subject_sql = 'SELECT subject_name FROM subjects WHERE subject_id = :subject_id';
                                    $subject_stmt = $conn->prepare($subject_sql);
                                    $subject_stmt->bindParam(':subject_id', $subject_id);
                                    $subject_stmt->execute();
                                    $subject = $subject_stmt->fetch();
                                    echo $subject['subject_name']; 
                                    ?>
                                </td>
                                <td>
                                    <a href="update_teacher.php?id=<?php echo $teacher['teacher_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="delete_teacher.php?id=<?php echo $teacher['teacher_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this teacher?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
