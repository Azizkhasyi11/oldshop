<?php
$id = $_GET['id'] ?? 1;

// call getProduct method
$detail = $product->getProduct($id);

if ($detail):
  ?>
  <h1>Product Detail</h1>
  <div class="row">
    <div class="col-md-6">
      <img src="/assets/<?= htmlspecialchars($detail['image']) ?>" alt="Product Image" class="img-fluid rounded">
    </div>
    <div class="col-md-6 bg-secondary py-5 rounded center">
      <h2><?= htmlspecialchars($detail['name']) ?></h2>
      <p><?= htmlspecialchars($detail['description']) ?></p> <!-- Assuming there's a description field -->
      <p>Price: Rp. <?= htmlspecialchars(number_format($detail['price'])) ?></p> <!-- Assuming there's a price field -->
      <button class="btn btn-primary">Add to Cart</button>
    </div>
  </div>
<?php else: ?>
  <p>Product not found.</p>
  <a href="/" class="text-white">Return to homepage</a>
<?php endif; ?>