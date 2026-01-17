<?php
require_once __DIR__ . '/../includes/header.php';
redirect_if_not_admin();
?>
<div class="container mt-5">
  <h2 class="text-center mb-4">Admin Dashboard</h2>
  <div class="card shadow-lg border-0 rounded-3 p-4">
    <h5 class="text-muted mb-3">Welcome, <?php echo e($_SESSION['admin_name']); ?> 👋</h5>
    <div class="d-grid gap-3">

      <a href="/Vishw-Vidya/admin/manage_users.php" class="btn btn-outline-primary btn-lg">
        👥 Manage Users
      </a>

      <a href="/Vishw-Vidya/admin/manage_authors.php" class="btn btn-outline-success btn-lg">
        ✍️ Manage Authors
      </a>

      <a href="/Vishw-Vidya/admin/manage_blogs.php" class="btn btn-outline-warning btn-lg">
        📰 Manage Blogs
      </a>

      <a href="/Vishw-Vidya/admin/logout.php" class="btn btn-danger btn-lg">
        🚪 Logout
      </a>

    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
