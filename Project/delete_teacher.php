<?php
session_start();
include('db.php');

if (!isset($_GET['id'])) {
    header('Location: index_teachers.php'); // If no teacher ID is provided, redirect to the teacher list.
    exit();
}

$id = $_GET['id'];

// Delete the teacher from the database
$sql = 'DELETE FROM teachers WHERE teacher_id = :id';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

$_SESSION['message'] = 'Teacher deleted successfully!';
header('Location: index_teachers.php'); // Redirect to teacher list after delete
exit();
?>
