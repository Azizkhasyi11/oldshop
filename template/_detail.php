<?php
$id = $_GET['id'] ?? 1;

// call getProduct method
$detail = $product->getProduct($id);

if ($detail):
  ?>
  <h1>Product Detail</h1>
  <div class="row">
    <div class="col-md-6">
      <img src="<?= htmlspecialchars($detail['image']) ?>" alt="Product Image" class="img-fluid">
    </div>
    <div class="col-md-6">
      <h2><?= htmlspecialchars($detail['name']) ?></h2>
      <p><?= htmlspecialchars($detail['description']) ?></p> <!-- Assuming there's a description field -->
      <p>Price: Rp. <?= htmlspecialchars(number_format($detail['price'])) ?></p> <!-- Assuming there's a price field -->
      <button class="btn btn-primary">Add to Cart</button>
    </div>
  </div>
<?php else: ?>
  <p>Product not found.</p>
<?php endif; ?>