<h1 class="mb-4 text-center">Products</h1>
<div class="row">
  <?php $i = 1;
  if ($products):
    foreach ($products as $row): ?>
      <div class="col-md-4 mb-4">
        <a href="detail.php?id=<?= $row['id'] ?>" class="card-link text-decoration-none">
          <div class="card h-100 shadow-sm">
            <div class="card-img-container">
              <img src="assets/<?= $row['image'] ?>" class="card-img-top img-1-1" alt="Product Image 1"
                onerror="this.src='https://via.placeholder.com/150'">
            </div>
            <div class="card-body d-flex flex-column">
              <h5 class="card-title text-white"><?= $row['name'] ?></h5>
              <p class="card-text"><?= excerpt($row['description']) ?></p>
              <p class="card-text"><strong>Rp. <?= number_format($row['price']) ?></strong></p>
              <div class="mt-auto d-flex flex-column gap-2">
                <!-- Form to add product to cart -->
                <form action="" method="post" class="d-flex flex-column gap-3">
                  <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                  <div class="d-flex gap-2 align-items-center">
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" class="form-control w-25" id="quantity" value="1" min="0"
                      max="<?= $row['stock'] ?>">
                    <!-- Default quantity set to 1 -->
                  </div>
                  <button type="submit" class="btn btn-primary">Buy Now</button>
                </form>
                <span class="text-secondary fs-6">Stock: <?= $row['stock'] ?></span>
                <?php if (isAdmin()): ?>
                  <a class="btn btn-success" href="/product/edit.php?id=<?= $row['id'] ?>">Edit</a>
                  <a class="btn btn-danger" href="/product/remove.php?id=<?= $row['id'] ?>">Remove</a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </a>
      </div>
      <?php $i++ ?>
    <?php endforeach;
  else: ?>
    <div class="container mt-5 text-center">
      <p>Product not found.</p>
      <a href="/" class="btn btn-secondary">Return to Homepage</a>
    </div>
  <?php endif; ?>
</div>