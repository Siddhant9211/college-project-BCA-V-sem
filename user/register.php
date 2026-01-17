<?php
require_once __DIR__ . '/../includes/header.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pass = $_POST['password'];

    if ($name && $email && $pass) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Email already registered.";
        } else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $hash]);
            $success = "Registration successful. You can now login.";
        }
    } else {
        $error = "All fields required.";
    }
}
?>
<h2>User Registration</h2>
<?php if(!empty($error)): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>
<?php if(!empty($success)): ?><div class="alert alert-success"><?php echo e($success); ?></div><?php endif; ?>

<form method="post">
  <div class="mb-3"><label>Name</label><input class="form-control" name="name"></div>
  <div class="mb-3"><label>Email</label><input class="form-control" name="email" type="email"></div>
  <div class="mb-3"><label>Password</label><input class="form-control" name="password" type="password"></div>
  <button class="btn btn-primary">Register</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
