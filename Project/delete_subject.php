<?php
session_start();
include('db.php');

if (isset($_GET['id'])) {
    $subject_id = $_GET['id'];
    
    // Delete the subject from the database
    $sql = 'DELETE FROM subjects WHERE subject_id = :subject_id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':subject_id', $subject_id);
    $stmt->execute();
    
    $_SESSION['success'] = 'Subject deleted successfully.';
    header('Location: subjects.php');
    exit();
} else {
    $_SESSION['error'] = 'Subject not found.';
    header('Location: subjects.php');
    exit();
}
?>
