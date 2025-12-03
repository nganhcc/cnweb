<?php require_once "data/flowers.php"; ?>
<!doctype html>
<html lang='vi'>
    <header>
        <meta charset='utf-8'>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Flowers</title>
        <link rel="stylesheet" href="assets/css/style.css">
    </header>
    <body>
        <?php include "includes/header.php";?>
        <div class="container">
            <h1>Top nhung loai hoa duoc yeu thich nhat mua tet</h1>
            <?php foreach($flowers as $index => $flower): ?>
                <div class="flower-item">
                    <h2><?=($index +1)?>. <?= $flower['name'] ?></h2>
                    <p><?= htmlspecialchars($flower['mota']) ?></p>
                    <img src="<?= htmlspecialchars($flower['loc']) ?>" alt="<?= htmlspecialchars($flower['name']) ?>">
                </div>
            <?php endforeach; ?>
        </div>
        <?php include "includes/footer.php";?>
    </body>
</html>