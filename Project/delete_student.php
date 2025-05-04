<?php
session_start();
include('db.php');

if (!isset($_GET['id'])) {
    header('Location: index.php'); // If no student ID is provided, redirect to the student list.
    exit();
}

$id = $_GET['id'];

// Delete the student from the database
$sql = 'DELETE FROM students WHERE student_id = :id';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

$_SESSION['message'] = 'Student deleted successfully!';
header('Location: index.php'); // Redirect to student list after delete
exit();
?>
