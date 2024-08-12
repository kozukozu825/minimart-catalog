<nav class="navbar navbar-expand navbar-dark bg-dark" style="margin-bottom: 80px;">
  <div class="container">
    <!-- NAVBAR BRAND -->
     <a href="products.php" class="navbar-brand">
      <h1 class="h4 mb-0 text-uppercase">Minimart Catalog</h1>
     </a>

     <!-- NAV LINKS -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="products.php" class="nav-link">Products</a>
        </li>
        <li class="nav-item">
          <a href="sections.php" class="nav-link">Sections</a>
        </li>       
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a href="profile.php" class="nav-link fw-bold"><?= $_SESSION['username'];?></a>
        </li>
        <li class="nav-item">
          <a href="logout.php" class="nav-link text-danger">Logout</a>
        </li>
      </ul>
  </div>

</nav>