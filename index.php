<?php
require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section text-center py-5">
  <h1 class="display-5 fw-bold text-white mb-3">Welcome to Vishw-Vidya</h1>
  <p class="lead text-light">Explore ancient wisdom and modern insights shared by our community.</p>
</section>

<!-- Search Bar -->
<section class="search-section my-5">
  <form method="get" action="/Vishw-Vidya/all_blogs.php" class="search-form mx-auto">
    <div class="input-group shadow">
      <input type="text" name="q" class="form-control form-control-lg" placeholder="Search blogs by title or keyword...">
      <button class="btn btn-primary btn-lg px-4">Search</button>
    </div>
  </form>
</section>

<!-- Categories -->
<section class="categories-section text-center mb-5">
  <h3 class="fw-semibold mb-4 text-dark">Explore by Category</h3>
  <div class="d-flex flex-wrap justify-content-center gap-3">
    <a class="btn btn-outline-secondary category-btn" href="/Vishw-Vidya/all_blogs.php?category=Archaeological">Archaeological</a>
    <a class="btn btn-outline-secondary category-btn" href="/Vishw-Vidya/all_blogs.php?category=Scriptures">Scriptures</a>
    <a class="btn btn-outline-secondary category-btn" href="/Vishw-Vidya/all_blogs.php?category=Coins">Coins</a>
    <a class="btn btn-outline-secondary category-btn" href="/Vishw-Vidya/all_blogs.php?category=Weapons">Weapons</a>
    <a class="btn btn-outline-secondary category-btn" href="/Vishw-Vidya/all_blogs.php?category=Manuscripts">Manuscripts</a>
  </div>
</section>

<!-- View All -->
<div class="text-center mb-5">
  <a class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm" href="/Vishw-Vidya/all_blogs.php">
    View All Blogs
  </a>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
