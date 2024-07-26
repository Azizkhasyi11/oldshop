<?php

if (isset($_SESSION['login'])) {
  $user = getUser($_SESSION['user_id']);
}
// $user = getUser($_SESSION['user_id'] ?? '');

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">OldShop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/about.php">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/contact.php">Contact</a>
        </li>
      </ul>
      <ul class="navbar-nav">
        <?php if (!isset($_SESSION['login'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="/auth/login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/auth/register.php">Register</a>
          </li>
        <?php else: ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-fill"></i> <?= $user['username'] ?>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="/cart.php"><i class="bi bi-cart-fill"></i> Cart</a></li>
              <li><a class="dropdown-item" href="/checkout.php"><i class="bi bi-box-seam"></i> Checkout</a></li>
              <li><a class="dropdown-item" href="/user.php"><i class="bi bi-person-fill-gear"></i> User Details</a></li>
            </ul>
          </li>
          <?php if ($_SESSION['admin']): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Admin
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/product/add.php">Add Product</a></li>
                <li><a class="dropdown-item" href="/admin/users.php">User List</a></li>
              </ul>
            </li>
          <?php endif; ?>
          <li class="nav-item">
            <a class="nav-link" href="/auth/logout.php">
              <i class="bi bi-box-arrow-right"></i> Logout
            </a>
          </li>
        <?php endif; ?>
        <?php if (basename($_SERVER['PHP_SELF']) !== 'search.php'): ?>
          <form class="d-flex" role="search" action="search.php" method="get">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>