<?php



$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'school';

try{
    $conn = new PDO("mysql:host=$host;dbname=$dbname" , $username , $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    echo 'connected successfully';
}catch(PDOException $e) {
    echo 'connection failed' . $e->getMessage();
}
?>