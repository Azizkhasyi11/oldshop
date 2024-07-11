<?php
session_start();
require '../scripts/functions.php';

// Check for cookies
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
  $id = $_COOKIE['id'];
  $key = $_COOKIE['key'];

  // Fetch username based on the ID
  $result = mysqli_query($conn, "SELECT username FROM users WHERE id = '$id'");
  $row = mysqli_fetch_assoc($result);

  // Verify the cookie and username
  if ($key === hash('sha256', $row['username'])) {
    $_SESSION['login'] = true;
  }
}

// if (isset($_SESSION['login'])) {
//     header('Location: index.php');
//     exit;
// }

$error = false;
if (isset($_POST["login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

  if (mysqli_num_rows($result) === 1) {
    // Verify the password
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row["password"])) {
      // Set session
      $_SESSION["login"] = true;

      // Check for remember me option
      if (isset($_POST["remember"])) {
        // Create cookies
        setcookie('id', $row['id'], time() + 86400);
        setcookie('key', hash('sha256', $row['username']), time() + 86400);
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
  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="d-flex flex-column min-vh-100" data-bs-theme="dark">
  <div class="container my-5">
    <h1 class="mb-4 text-center">Login</h1>

    <?php if ($error): ?>
      <div class="alert alert-danger" role="alert">
        Username or Password is incorrect
      </div>
    <?php endif; ?>

    <form action="" method="post" class="needs-validation border p-5 rounded" novalidate>
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" id="username" class="form-control" required>
        <div class="invalid-feedback">
          Please enter your username.
        </div>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
        <div class="invalid-feedback">
          Please enter your password.
        </div>
      </div>
      <div class="form-check mb-3">
        <input type="checkbox" name="remember" id="remember" class="form-check-input">
        <label for="remember" class="form-check-label">Remember Me</label>
      </div>
      <button type="submit" name="login" class="btn btn-primary">Login</button>
      <a href="register.php" class="btn btn-secondary">Register</a>
    </form>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

  <script>
    // Bootstrap form validation
    (function () {
      'use strict'

      var forms = document.querySelectorAll('.needs-validation')

      Array.prototype.slice.call(forms)
        .forEach(function (form) {
          form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }

            form.classList.add('was-validated')
          }, false)
        })
    })()
  </script>
</body>

</html>