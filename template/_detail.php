<?php

$id = $_GET['id'];

// Call getProduct method
$detail = $product->getProduct($id);

if ($detail):
  ?>
  <div class="container mt-5">
    <h1 class="text-center mb-4">Product Detail</h1>
    <div class="row">
      <div class="col-md-6">
        <img src="/assets/<?= htmlspecialchars($detail['image']) ?>" alt="Product Image" class="img-fluid rounded shadow">
      </div>
      <div class="col-md-6 border py-5 rounded shadow-sm">
        <h2 class="mb-3"><?= htmlspecialchars($detail['name']) ?></h2>
        <hr>
        <p><?= nl2br(htmlspecialchars($detail['description'])) ?></p> <!-- Convert \n to <br> -->
        <p class="h4">Price: Rp. <?= htmlspecialchars(number_format($detail['price'])) ?></p>
        <form action="cart.php" method="post">
          <input type="hidden" name="product_id" value="<?= $detail['id'] ?>">
          <div class="d-flex align-items-center my-3">
            <label for="quantity" class="me-2">Quantity:</label>
            <input type="number" name="quantity" id="quantity" value="1" class="form-control w-25">
          </div>
          <button type="submit" class="btn btn-primary">Add to Cart</button>
        </form>
        <a href="/" class="btn btn-secondary mt-3">Return to Homepage</a>
      </div>
    </div>
  </div>
<?php else: ?>
  <div class="container mt-5 text-center">
    <p>Product not found.</p>
    <a href="/" class="btn btn-secondary">Return to Homepage</a>
  </div>
<?php endif; ?>

<?php
include 'footer.php';
?>