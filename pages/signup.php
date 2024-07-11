<?php
session_start();
include '../assets/php/functions.php';

if (isset($_SESSION['login'])) {
    header('Location: ../login/');
    exit;
}

if (isset($_POST["submit"])) {
    // var_dump($_POST); die;
    // cek
    if (signup($_POST) > 0) {
        echo "
        <script>
            alert('Sign Up berhasil!');
            document.location.href = '../index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Sign Up gagal!');
            document.location.href = '../index.php';
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
    <link rel="stylesheet" href="../assets/css/signup.css">
    <title>Sign Up Page</title>
    <link rel="icon" href="assets/img/icon.jpg">
</head>

<body>
    <div class="login">
        <h1 class="title"><i class="bi bi-person-fill"></i> Sign Up</h1>
        <form action="" method="post">
            <ul>
                <li>
                    <label for="">Nama:</label><br>
                    <input type="text" name="nama" id="nama">
                </li>
                <li>
                    <label for="">Password:</label><br>
                    <input type="password" name="password" id="password">
                </li>
                <li>
                    <label for="">Repeat Password:</label><br>
                    <input type="password" name="repeat_password" id="password">
                </li>
                <li>
                    <button type="submit" class="signup" name="submit">Sign Up</button>
                </li>
            </ul>
        </form>
        <a href="login.php" class="login">Arleady have account?</a>
    </div>

    <?php require '../assets/components/footer.php' ?>
</body>

</html>