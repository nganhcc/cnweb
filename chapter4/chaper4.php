<?php
$host='localhost';
$dbname='qlsv';
$username='root';
$pass='';
$dsn="mysql:host=$host;dbname=$dbname;charset=utf8mb4";
try{
    $pdo = new PDO($dsn, $username, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'ket noi thanh cong';
}catch (PDOException $e){
    die("Ket noi that bai: ".$e->getMessage());
}

$stmt_select = null;

if(isset($_POST['hoten'])){
    $hoten=$_POST['hoten'];
    $email=$_POST['email'];
    $sql="insert into sinhvien (hoten, email) values (?, ?)";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([$hoten, $email]);

    header("Location: ". $_SERVER['PHP_SELF']);
    exit;
}

$sql_select= "select * from sinhvien order by ngay_tao desc";
$stmt_select=$pdo->query($sql_select);
?>

<!doctype html>
<html lang='vi'>
    <head>
        <meta charset="utf-8">
        <title>PHT chuong 4 - website huong du lieu</title>
         <style> 
            table { width: 100%; border-collapse: collapse; } 
            th, td { border: 1px solid #ddd; padding: 8px; } 
            th { background-color: #f2f2f2; } 
        </style> 
    </head>
    <body>
        <h2> Them sinh vien moi</h2>
        <form action="" method="POST">
            Ho ten: <input type="text" name='hoten' required>
            Email: <input type="email" name='email' required>
            <button type='submit'>Them</button>
        </form>
        <h2>Danh sach sinh vien</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Ho ten</th>
                <th>Email</th>
                <th>Ngay tao</th>
            </tr>
            <?php if($stmt_select): while($row= $stmt_select->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['hoten']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['ngay_tao']) ?></td>
                </tr>
            <?php endwhile; endif ?>
        </table>
    </body>
</html>