<!DOCTYPE html> 
<html lang="vi"> 
<head> 
    <meta charset="UTF-8"> 
    <title>PHT Chương 6 - MVC</title> 
    <style> 
        table { width: 100%; border-collapse: collapse; } 
        th, td { border: 1px solid #ddd; padding: 8px; } 
        th { background-color: #f2f2f2; } 
    </style> 
</head> 
<body> 
    <h2>Thêm Sinh Viên Mới (Kiến trúc MVC)</h2> 
    <form action="index.php" method="POST">
        <label for="hoten">Ho ten: </label>
        <input type="text" required name="hoten" id="hoten">
        <label for="email">Email: </label>
        <input type="email" required name="email" id="email">
        <button type="submit" >Submit</button>
    </form>
     
    <h2>Danh Sách Sinh Viên (Kiến trúc MVC)</h2> 
    <table> 
        <tr> 
            <th>ID</th> 
            <th>Tên Sinh Viên</th> 
            <th>Email</th> 
            <th>Ngày Tạo</th> 
        </tr> 
        <?php foreach($danh_sach_sv as $i=>$sv):?>
            <tr>
                <td><?= htmlspecialchars($sv['id']) ?></td>
                <td><?= htmlspecialchars($sv['hoten']) ?></td>
                <td><?= htmlspecialchars($sv['email']) ?></td>
                <td><?= htmlspecialchars($sv['ngay_tao']) ?></td>
            </tr>
        <?php endforeach; ?> 
    </table> 
</body> 
</html> 