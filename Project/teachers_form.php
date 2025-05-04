<?php 
session_start(); 
include('db.php'); 
// Include base.php here only once
include('base.php'); 

// Add teacher logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $subject_id = $_POST['subject_id'];

    // Check if all fields are filled
    if (!empty($first_name) && !empty($last_name) && !empty($subject_id)) {
        // Insert new teacher into the database
        $sql = "INSERT INTO teachers (first_name, last_name, subject_id) VALUES (:first_name, :last_name, :subject_id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':subject_id', $subject_id);

        if ($stmt->execute()) {
            // Redirect to the teacher index page (index_teachers.php) after successful insertion
            header('Location: index_teachers.php');
            exit(); // Make sure to stop further code execution
        } else {
            echo "<script>alert('Error adding teacher.');</script>";
        }
    } else {
        echo "<script>alert('Please fill in all fields.');</script>";
    }
}
?>

<!doctype html>
<html lang="en">
  <body>
    <div class="container">
        <div class="row justify-content-center m-4">
            <div class="col-6">
                <div class="display-6 text-center">Add New Teacher</div>
                <form action="teachers_form.php" method="post" class="form-group">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" placeholder="Enter First Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" placeholder="Enter Last Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject_id" class="form-label">Subject</label>
                        <select name="subject_id" class="form-control" required>
                            <?php
                            $sql = 'SELECT * FROM subjects';
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $subjects = $stmt->fetchAll();
                            foreach ($subjects as $subject) {
                                echo "<option value='" . $subject['subject_id'] . "'>" . $subject['subject_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="submit" value="Add Teacher" class="btn btn-primary form-control">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
