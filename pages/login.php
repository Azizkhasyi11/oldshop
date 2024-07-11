<?php
session_start();
require '../assets/php/functions.php';

if (isset($_SESSION['login'])) {
    header('Location: ../');
    exit;
}

// Check if form is submitted
if (isset($_POST["login"])) {
    $username = mysqli_real_escape_string($conn, $_POST["nama"]); // Sanitize input
    $password = $_POST["password"];

    // Fetch user from database
    $result = mysqli_query($conn, "SELECT * FROM users WHERE nama = '$username'");

    if ($result) {
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row["password"])) {
                // Set session and redirect on successful login
                $_SESSION["login"] = true;
                $_SESSION["data"] = $row["id"]; // Store only the id from the row
                // var_dump($_SESSION["data"]);
                header("Location: ../index.php");
                exit;
            } else {
                $error = "Invalid username or password";
            }
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Database error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/login.css">
    <title>Log In Page</title>
    <link rel="icon" href="assets/img/icon.jpg">
</head>

<body>
    <div class="login">
        <h1 class="title"><i class="bi bi-person-fill"></i> Login</h1>
        <?php if (isset($error)) : ?>
            <p style="color: red; font-style: italic;"><?= $error ?></p>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                    <button type="submit" class="login" name="login">Login</button>
                </li>
            </ul>
        </form>
        <a href="signup.php" class="signup">Need an account?</a>
    </div>

    <?php require '../assets/components/footer.php' ?>
</body>

</html>