<?php
require_once __DIR__ . '/../includes/header.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id, password, name FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: /Vishw-Vidya/index.php");
        exit;
    } else {
        $error = "Invalid credentials.";
    }
}
?>
<h2>User Login</h2>
<?php if(!empty($error)): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>
<form method="post">
  <div class="mb-3"><label>Email</label><input class="form-control" name="email" type="email"></div>
  <div class="mb-3"><label>Password</label><input class="form-control" name="password" type="password"></div>
  <button class="btn btn-primary">Login</button>
</form>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
