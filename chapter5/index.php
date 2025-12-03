<?php
require_once "models/sinhvien_model.php";

$host='localhost';
$dbname="qlsv";
$username="root";
$pass='';

$dsn="mysql:host=$host;dbname=$dbname;charset=utf8mb4";
try{
    $pdo= new PDO($dsn, $username, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    die("Failed to connect " .$e->getMessage());
}


if (isset($_POST['hoten'])){
    $ten=$_POST['hoten'];
    $email=$_POST['email'];
    addSinhVien($pdo, $ten, $email);
    header("Location: index.php");
    exit;
}
$danh_sach_sv=getAllSinhVien($pdo);
include "views/sinhvien_view.php";
?>

