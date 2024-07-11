<?php
session_start();
require '../functions.php';

//cek cookie
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
  $id = $_COOKIE['id'];
  $key = $_COOKIE['key'];

  // ambil username == id
  $result = mysqli_query($conn, "SELECT username FROM users WHERE id = '$id'");
  $row = mysqli_fetch_assoc($result);

  // cek cookie and username
  if ($key === hash('sha256', $row['username'])) {
    $_SESSION['login'] = true;
  }
}

if (isset($_SESSION['login'])){
    header('Location: /');
    exit;
}

if (isset($_POST["login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

  if (mysqli_num_rows($result) === 1) {
    // cek password
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row["password"])) {
      // set session
      $_SESSION["login"] = true;
      $_SESSION["user_id"] = $row["id"];

      // cek remember
      if (isset($_POST["remember"])) {
        // create cookie
        setcookie('id', $row['id'], time() + 60);
        setcookie('key', hash('sha256', $row['username']), time() + 60);
      }

      header("Location: index.php");
      exit;
    }
  }

  $error = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <style>
    label {
      display: block;
    }

    label.remember {
      display: inline;
    }

    p {
      color: red;
      font-style: italic;
    }
  </style>
</head>

<body>
  <h1>Halaman Login</h1>
  <p>Username / Password salah</p>

  <form action="" method="post">
    <ul>
      <li>
        <label for="username">Username :</label>
        <input type="text" name="username" id="username">
      </li>
      <li>
        <label for="password">Password :</label>
        <input type="password" name="password" id="password">
      </li>
      <li>
        <input type="checkbox" name="remember" id="remember">
        <label for="remember" class="remember">Remember Me</label>
      </li>
      <li>
        <button type="submit" name="login">Login</button>
      </li>
    </ul>
  </form>
</body>

</html>