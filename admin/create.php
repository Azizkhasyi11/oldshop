<?php
session_start();
require '../assets/php/functions.php';

if (!isset($_SESSION['login'])) {
    header("Location: ./pages/login.php");
    exit;
}

if(isset($_POST['submit'])){
    // var_dump($_POST); var_dump($_FILES); die;
    if (create($_POST) > 0) {
        echo "
        <script>
            alert('Sign Up berhasil!');
            document.location.href = 'products.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Sign Up gagal!');
            document.location.href = 'products.php';
        </script>
        ";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/admin/create.css">
    <title>Create</title>
</head>

<body>
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" id="id" name="id">
            <ul>
                <li>
                    <label for="name">Name:</label><br>
                    <input type="text" id="name" name="name"><br>
                </li>
                <li>
                    <label for="img">Image:</label><br>
                    <input type="file" id="img" name="img" accept=".png"><br>
                </li>
                <li>
                    <label for="harga">Harga:</label><br>
                    <input type="text" id="harga" name="harga"><br>
                </li>
                <li>
                    <label for="stok">Stok:</label><br>
                    <input type="text" id="stok" name="stok"><br>
                </li>
            </ul>
            <input type="submit" value="Submit" name="submit">
        </form>
    </div>
</body>

</html>