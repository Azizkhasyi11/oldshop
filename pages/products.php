<?php
session_start();

require '../assets/php/functions.php';

$query = "SELECT * FROM products";

$rows = query($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body data-bs-theme="dark">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">BrandName</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./product/add.php">Add Product</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Product Cards -->
  <div class="container my-5">
    <div class="row">
      <?php if (is_array($rows) && !empty($rows)): ?>
        <?php foreach ($rows as $row): ?>
          <div class="col-md-4">
            <div class="card">
              <img src="../<?= $row['img'] ?>" class="card-img-top" alt="Product Image <?= $row['id'] ?>"
                onerror="this.src='https://via.placeholder.com/150'">
              <div class="card-body">
                <h5 class="card-title"><?= $row['name'] ?></h5>
                <p class="card-text"><?= $row['description'] ?></p>
                <p class="card-text"><strong>Rp. <?= number_format($row['price'], 0, '.', '.') ?></strong></p>
                <a href="#" class="btn btn-success">Buy Now!</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No data available.</p>
      <?php endif; ?>
      <!-- <div class="col-md-4">
        <div class="card">
          <img src="path/to/image2.jpg" class="card-img-top" alt="Product Image 2"
            onerror="this.src='https://via.placeholder.com/150'">
          <div class="card-body">
            <h5 class="card-title">Product 2</h5>
            <p class="card-text">This is a short description of Product 2.</p>
            <p class="card-text"><strong>$29.99</strong></p>
            <a href="#" class="btn btn-primary">Buy Now</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <img src="path/to/image3.jpg" class="card-img-top" alt="Product Image 3"
            onerror="this.src='https://via.placeholder.com/150'">
          <div class="card-body">
            <h5 class="card-title">Product 3</h5>
            <p class="card-text">This is a short description of Product 3.</p>
            <p class="card-text"><strong>$39.99</strong></p>
            <a href="#" class="btn btn-primary">Buy Now</a>
          </div>
        </div>
      </div> -->
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>