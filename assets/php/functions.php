<?php

CONST UPLOADS = '../uploads/';

$servername = "localhost"; // Change as necessary
$username = "root"; // Change as necessary
$password = "password"; // Change as necessary
$dbname = "mencobalagi"; // Change as necessary

// Connect database
$conn = mysqli_connect($servername, $username, "", $dbname);

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
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

function signup($data)
{
    global $conn;
    $nama = stripslashes($data["nama"]);
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $repeatPass = mysqli_real_escape_string($conn, $data["repeat_password"]);
    $current_timestamp = time();

    // Cek duplicate username
    $cek = mysqli_query($conn, "SELECT nama FROM users WHERE nama = '$nama'");
    if (mysqli_fetch_assoc($cek)) {
        echo "
        <script>
            alert('Username sudah terdaftar');
        </script>
            ";
        return false;
    }

    if ($password !== $repeatPass) {
        echo "
        <script>
            alert('Password tidak sama');
        </script>
        ";
        return 0;
    }

    // Encryp Pass
    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users
                VALUES
                ('', '$nama', '', '', '', '', '$password', '$current_timestamp')";
    // Add the user
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function check($data)
{
    if (isset($data)) {
        echo "Guest";
    } else {
        return $data;
    }
}

function ubah($data)
{
    global $conn;

    $id = $data["id"];
    $nama = stripslashes(htmlspecialchars($data["username"]));
    $gender = ucfirst(htmlspecialchars($data["gender"]));
    $hobi = htmlspecialchars($data["hobi"]);
    $umur = htmlspecialchars($data["umur"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $tanggal_dibuat = $data["tanggal_dibuat"];

    // Cek if the nama is already in database
    $cekNama = mysqli_query($conn, "SELECT nama FROM users WHERE nama = '$nama' AND id != '$id'");
    if (mysqli_fetch_assoc($cekNama)) {
        echo "
        <script>
            alert('Nama sudah terdaftar');
        </script>
        ";
        return 0;
    } else {
        if ($id && $nama) {
            // Lanjutkan dengan perubahan data
        } else {
            echo "
            <script>
                alert('ID dan Nama harus diisi');
            </script>
            ";
            return 0;
        }
    }
    

    if ( !is_numeric($umur) && $umur !== ""){
        echo "
        <script>
            alert('Umur harus angka!');
        </script>
        ";
        return 0;
    }

    if (strtolower($gender) !== "pria" && strtolower($gender) !== "wanita" && $gender !== "") {
        echo "
        <script>
            alert('Gender salah! (pria/wanita)');
        </script>
        ";
        return 0;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE users SET
            nama = '$nama',
            gender = '$gender',
            hobi = '$hobi',
            umur = '$umur',
            alamat = '$alamat',
            password = '$password',
            tanggal_dibuat = '$tanggal_dibuat'
        WHERE id = '$id'";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload()
{
    $namaFile = $_FILES["img"]["name"];
    $ukuranFile = $_FILES["img"]["size"];
    $error = $_FILES["img"]["error"];
    $tmpName = $_FILES["img"]["tmp_name"];

    // Check if the file is uploaded
    if ($error === 4) {
        echo "
            <script>
                alert('Upload gambar terlebih dahulu');
            </script>
            ";
        return false;
    }

    // Check if the file is an image
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "
            <script>
                alert('File yang di upload bukan gambar');
            </script>
            ";
        return false;
    }

    // Check if the file is not too big
    if ($ukuranFile > 1000000) {
        echo "
            <script>
                alert('Ukuran gambar terlalu besar');
            </script>
            ";
        return false;
    }

    // Generate a new name for the file
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, UPLOADS . $namaFileBaru);
    return $namaFileBaru;
}

function create($data) {
    global $conn;
    // Create a new product that has id, name, img, harga, and stok
    // $id = $data["id"];
    $nama = htmlspecialchars($data["name"]);
    // $img = htmlspecialchars($data["img"]);
    $harga = htmlspecialchars($data["harga"]);
    $stok = htmlspecialchars($data["stok"]);

    // Check if the product is already in the database
    $cek = mysqli_query($conn, "SELECT name FROM products WHERE name = '$nama'");
    if (mysqli_fetch_assoc($cek)) {
        echo "
        <script>
            alert('Product sudah ada');
        </script>
        ";
        return 0;
    }

    // Upload the img
    $img = upload();
    if (!$img) {
        return false;
    }

    $query = "INSERT INTO products
                VALUES
                ('', '$nama', '$img', '$harga', '$stok')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

define('PAGES', '../pages/');