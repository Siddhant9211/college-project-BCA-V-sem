<?php
require_once __DIR__ . '/../includes/header.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id, password FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();
    if ($admin && password_verify($pass, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $username;
        header("Location: /Vishw-Vidya/admin/dashboard.php");
        exit;
    } else {
        $error = "Invalid credentials.";
    }
}
?>
<h2>Admin Login</h2>
<?php if(!empty($error)): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>
<form method="post">
  <div class="mb-3"><label>Username</label><input class="form-control" name="username"></div>
  <div class="mb-3"><label>Password</label><input class="form-control" name="password" type="password"></div>
  <button class="btn btn-primary">Login</button>
</form>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
