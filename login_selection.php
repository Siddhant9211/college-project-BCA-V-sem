<?php
require_once __DIR__ . '/includes/header.php';
?>

<style>
.role-selection {
  display: flex;
  justify-content: center;
  gap: 30px;
  flex-wrap: wrap;
  margin-top: 40px;
  margin-bottom: 60px;
}

.role-card {
  background: #ffffff;
  border: 1px solid #e0e0e0;
  border-radius: 12px;
  width: 300px;
  text-align: center;
  padding: 25px 20px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  transition: all 0.3s ease-in-out;
}

.role-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.role-card h4 {
  font-size: 1.5rem;
  font-weight: 700;
  color: #2c3e50;
  margin-bottom: 10px;
}

.role-card p {
  color: #6c757d;
  font-size: 0.95rem;
  margin-bottom: 20px;
}

.role-card .btn {
  width: 100%;
  border-radius: 8px;
  font-weight: 600;
  margin-bottom: 8px;
}

.page-title {
  text-align: center;
  font-weight: 700;
  font-size: 2rem;
  margin-top: 20px;
  color: #2c3e50;
}

.page-subtitle {
  text-align: center;
  font-size: 1rem;
  color: #6c757d;
  margin-bottom: 20px;
}
</style>

<h2 class="page-title">Login / Register</h2>
<p class="page-subtitle">Select your role below to continue:</p>

<div class="role-selection">
  <!-- USER -->
  <div class="role-card">
    <h4>User</h4>
    <p>Read and comment on blogs.</p>
    <a class="btn btn-outline-primary" href="/Vishw-Vidya/user/register.php">Register</a>
    <a class="btn btn-primary" href="/Vishw-Vidya/user/login.php">Login</a>
  </div>

  <!-- AUTHOR -->
  <div class="role-card">
    <h4>Author</h4>
    <p>Write and manage your blogs.</p>
    <a class="btn btn-outline-primary" href="/Vishw-Vidya/author/register.php">Register as Author</a>
    <a class="btn btn-primary" href="/Vishw-Vidya/author/login.php">Author Login</a>
  </div>

  <!-- ADMIN -->
  <div class="role-card">
    <h4>Admin</h4>
    <p>Site management (admin only).</p>
    <a class="btn btn-outline-primary" href="/Vishw-Vidya/admin/login.php">Admin Login</a>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
