<?php
ob_start();
include 'header.php';
// var_dump($_SESSION);
?>

<!-- Hero Section -->
<div class="container-fluid py-5 my-5">
  <div class="d-flex align-items-center justify-content-center text-center text-white">
    <div class="overlay"></div>
    <div class="hero-content">
      <h1>Welcome to OldShop</h1>
      <p>Discover the best products at unbeatable prices</p>
      <a href="#products" class="btn btn-primary btn-lg">Shop Now</a>
    </div>
  </div>
</div>

<!-- Main content area -->
<div class="container my-5" id="products">
  <?php include './template/_products.php'; ?>
</div>

<?php
include 'footer.php';
?>