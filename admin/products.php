<?php
session_start();
require '../assets/php/functions.php';
if (!isset($_SESSION['login'])) {
    header("Location: ./pages/login.php");
    exit;
}

$products = query("SELECT * FROM products");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/admin/products.css">
    <title>Products</title>
</head>

<body>
    <table border="1px" >
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Stock</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product) : ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo "Rp" . number_format($product['harga'], 0, ',', '.'); ?></td>
                    <td><img src="<?= $product['img'] ?>" alt=""></td>
                    <td><?= $product['stok'] ?></td>
                    <!-- Add more cells as needed -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>