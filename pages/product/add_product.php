<?php
require '../../assets/php/functions.php'; // Include your database connection and other necessary functions

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image'];
    $stock = $_POST['stock'];

    // Handle file upload
    $target_dir = "../../uploads/";
    $imageFileType = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
    $newFileName = time() . '.' . $imageFileType; // Create a new file name based on the current timestamp
    $target_file = $target_dir . $newFileName;
    $uploadOk = 1;
    $errorMessage = '';

    // Check if image file is a actual image or fake image
    $check = getimagesize($image["tmp_name"]);
    if ($check === false) {
        $errorMessage = "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $errorMessage = "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($image["size"] > 500000) {
        $errorMessage = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $errorMessage = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<script>alert('{$errorMessage}');</script>";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            echo "<script>alert('The file " . htmlspecialchars(basename($image["name"])) . " has been uploaded.');</script>";

            // Insert into database
            $sql = "INSERT INTO products (name, description, price, img, stock) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $relative_file_path = 'uploads/' . $newFileName; // Save the relative file path
            $stmt->bind_param("ssdsi", $name, $description, $price, $relative_file_path, $stock);

            if ($stmt->execute()) {
                echo "<script>alert('New product added successfully');</script>";
            } else {
                $errorMessage = "Error: " . $sql . "<br>" . $conn->error;
                echo "<script>alert('{$errorMessage}');</script>";
            }

            $stmt->close();
        } else {
            $errorMessage = "Sorry, there was an error uploading your file.";
            echo "<script>alert('{$errorMessage}');</script>";
        }
    }
}

$conn->close();
?>
