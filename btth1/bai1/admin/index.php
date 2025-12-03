<?php require_once "../data/flowers.php"; ?>
<!doctype html>
<html lang='vi'>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Quan li hoa - Admin</title>
    </head>
    <body>
    <?php include "../includes/header.php"; ?>
        <div class="container">
            <h2>Cac loai hoa dang duoc quan li</h2>
            <a href="#">Them hoa</a>
            <table border="1" width="100%">
                <tr>
                    <th>STT</th>
                    <th>Ten hoa</th>
                    <th>Hinh anh</th>
                    <th>Mo ta</th>
                    <th>Hanh dong</th>
                </tr>
                <?php foreach($flowers as $index => $flower): ?>
                    <tr>
                        <td><?= $index+1 ?></td>
                        <td><?= htmlspecialchars($flower["name"]) ?></td>
                        <td><img src="../<?= htmlspecialchars($flower["loc"])?>" width="100" alt="<?= htmlspecialchars($flower["name"]) ?>"></td>
                        <td><?= htmlspecialchars($flower["mota"])?></td>
                        <td>
                            <a href="#">Xoa</a>
                            <a href="#">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php include "../includes/footer.php"; ?>
    </body>
</html>