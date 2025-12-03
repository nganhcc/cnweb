<?php
function getAllSinhVien($pdo){
    $sql="select * from sinhvien";
    $stmt=$pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function addSinhVien($pdo, $ten, $email){
    $sql="insert into sinhvien(hoten, email) values (?,?)";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([$ten, $email]);
}
?>