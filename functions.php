<?php

require 'scripts/database/DBController.php';

require 'scripts/Product.php';

$db = new DBController();

$product = new Products($db);
$products = $product->getData();

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
    $firstname = stripslashes($data["firstname"]);
    $lastname = stripslashes($data["lastname"]);
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);
    $register_date = date("Y-m-d H:i:s");

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

    // Insert user data
    mysqli_query($conn, "INSERT INTO users VALUES(NULL, '$firstname', '$lastname', '$username',  '$password', '$register_date')");

    return mysqli_affected_rows($conn);
}

function login($data)
{
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);

    // Check if username exists
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if (!$result) {
        echo "
        <script>
            alert('Username tidak terdaftar');
        </script>
        ";
        return false;
    }

    // Check password
    $row = mysqli_fetch_assoc($result);
    if (!password_verify($password, $row["password"])) {
        echo "
        <script>
            alert('Password salah');
        </script>
        ";
        return false;
    }

    // Set session
    $_SESSION["login"] = true;
    $_SESSION["user_id"] = $row["id"];

    return true;
}

function logout()
{
    $_SESSION = [];
    session_unset();
    session_destroy();

    return true;
}

// -----------------------------
// |       Products            |
// -----------------------------

function getProducts()
{
    global $conn;

    $result = mysqli_query($conn, "SELECT * FROM products");
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function getProduct($id)
{
    global $conn;

    $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");

    return mysqli_fetch_assoc($result);
}

// -----------------------------
// |       Cart                |
// -----------------------------
function addToCart($data)
{
    $product_id = $data['product_id'];
    $user_id = $data['user_id'];
    $quantity = $data['quantity'];

    // Initialize cart session if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if product is already in cart
    if (isset($_SESSION['cart'][$user_id][$product_id])) {
        echo "
        <script>
            alert('Product sudah ada di cart');
        </script>
        ";
        return false;
    }

    // Add product to cart
    $_SESSION['cart'][$user_id][$product_id] = [
        'product_id' => $product_id,
        'quantity' => $quantity,
    ];

    return true;
}

function removeFromCart($data)
{
    $product_id = $data['product_id'];
    $user_id = $data['user_id'];

    // Check if product is in cart
    if (!isset($_SESSION['cart'][$user_id][$product_id])) {
        echo "
        <script>
            alert('Product tidak ada di cart');
        </script>
        ";
        return false;
    }

    // Remove product from cart
    unset($_SESSION['cart'][$user_id][$product_id]);

    return true;
}

function getCart($user_id)
{
    if (!isset($_SESSION['cart'][$user_id])) {
        return [];
    }

    return $_SESSION['cart'][$user_id];
}

function getCartTotal($user_id)
{
    $cart = getCart($user_id);
    $total = 0;

    foreach ($cart as $product) {
        $product_id = $product['product_id'];
        $quantity = $product['quantity'];

        $product = getProduct($product_id);
        $total += $product['price'] * $quantity;
    }

    return $total;
}

