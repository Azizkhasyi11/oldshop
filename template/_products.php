<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $product_id = $_POST['product_id'];
  $quantity = $_POST['quantity'];
  $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'guest';

  $data = [
    'product_id' => $product_id,
    'user_id' => $user_id,
    'quantity' => $quantity
  ];

  if (addToCart($data)) {
    echo "
    <script>
        alert('Product berhasil ditambahkan ke cart');
        window.location.href = 'cart.php';
    </script>
    ";
  } else {
    echo "
    <script>
        alert('Product sudah ada di cart');
        window.location.href = '/';
    </script>
    ";
  }
}
?>
<h1 class="mb-4 text-center">Products</h1>
<div class="row">
  <?php $i = 1;
  if ($products):
    foreach ($products as $row): ?>
      <div class="col-md-4">
        <div class="card">
          <img src="<?= $row['image'] ?>" class="card-img-top" alt="Product Image 1"
            onerror="this.src='https://via.placeholder.com/150'">
          <div class="card-body">
            <h5 class="card-title"><?= $row['name'] ?></h5>
            <p class="card-text"><?= $row['description'] ?></p>
            <p class="card-text"><strong>Rp. <?= number_format($row['price']) ?></strong></p>

            <!-- Form to add product to cart -->
            <form action="" method="post">
              <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
              <input type="hidden" name="quantity" value="1"> <!-- Default quantity set to 1 -->
              <button type="submit" class="btn btn-primary">Buy Now</button>
            </form>

            <a class="btn btn-secondary" href="detail.php?id=<?= $row['id'] ?>">Detail</a>
          </div>
        </div>
      </div>
      <?php $i++ ?>
    <?php endforeach;
  else: ?>
    No data
  <?php endif; ?>
</div>