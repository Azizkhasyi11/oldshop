<?php

$host = 'localhost';
$usernames = 'root';
// $password = '';
$database = 'oldshop';

$conn = mysqli_connect($host, $usernames, '', $database);

if (!$conn) {
  die('Connection failed: ' . mysqli_connect_error());
}

function query($query)
{
  global $conn;

  $result = mysqli_query($conn, $query);
  $rows = [];

  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  return $rows;
}

// -----------------------------
// |       Auth                |
// -----------------------------

function register($data)
{
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // Check if username already exists
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "
        <script>
            alert('Username sudah terdaftar');
        </script>
        ";
        return false;
    }

    // Check password confirmation
    if ($password !== $password2) {
        echo "
        <script>
            alert('Password tidak sama');
        </script>
        ";
        return false;
    }

    // Encrypt password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Add user to database
    mysqli_query($conn, "INSERT INTO users (username, password) VALUES('$username', '$password')");

    return mysqli_affected_rows($conn);
}