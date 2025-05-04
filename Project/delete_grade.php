<?php
session_start();
include('db.php');
include('base.php');

$grade_id = $_GET['id'] ?? null;

if ($grade_id) {
    $sql = 'DELETE FROM grades WHERE grade_id = :grade_id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':grade_id', $grade_id);
    $stmt->execute();
    $_SESSION['success'] = 'Grade deleted successfully!';
}

header('Location: grades_form.php');
exit();
