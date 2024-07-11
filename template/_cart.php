<?php
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
  echo "
    <script>
        alert('Please log in to view your cart.');
        window.location.href = '/auth/login.php';
    </script>
    ";
  exit;
}

$cartItems = getCart($user_id);
$total = getCartTotal($user_id);

// Process remove from cart action if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'remove') {
  $product_id = $_POST['product_id'];
  removeFromCart([
    'product_id' => $product_id,
    'user_id' => $user_id,
  ]);
  // Redirect back to cart to refresh the cart view after removal
  header("Location: cart.php");
  exit;
}
?>

<div class="container">
  <h2>Your Cart</h2>
  <?php if (empty($cartItems)): ?>
    <p>Your cart is empty.</p>
  <?php else: ?>
    <table class="table">
      <thead>
        <tr>
          <th>Product</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Total</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($cartItems as $item):
          $product = getProduct($item['product_id']);
          ?>
          <tr>
            <td><?php echo $product['name']; ?></td>
            <td><?php echo 'Rp.' . number_format($product['price'], 2); ?></td>
            <td><?php echo $item['quantity']; ?></td>
            <td><?php echo 'Rp. ' . number_format($product['price'] * $item['quantity'], 2); ?></td>
            <td>
              <form method="post">
                <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                <input type="hidden" name="action" value="remove">
                <button type="submit" class="btn btn-danger">Remove</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="cart-total">
      <h3>Total: <?php echo '$' . number_format($total, 2); ?></h3>
    </div>
    <div class="cart-actions">
      <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
    </div>
  <?php endif; ?>
</div>