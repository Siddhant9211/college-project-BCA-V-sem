<?php
require_once __DIR__ . '/../includes/header.php';
redirect_if_not_admin();

// Handle user delete
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$delete_id]);
    header("Location: manage_users.php?deleted=1");
    exit;
}

// Handle user block/unblock
if (isset($_GET['toggle'])) {
    $toggle_id = intval($_GET['toggle']);
    $stmt = $pdo->prepare("SELECT is_blocked FROM users WHERE id = ?");
    $stmt->execute([$toggle_id]);
    $user = $stmt->fetch();

    if ($user) {
        $new_status = $user['is_blocked'] ? 0 : 1;
        $stmt = $pdo->prepare("UPDATE users SET is_blocked = ? WHERE id = ?");
        $stmt->execute([$new_status, $toggle_id]);
        header("Location: manage_users.php?toggled=1");
        exit;
    }
}

// Fetch all users
$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll();
?>

<h2>Manage Users</h2>

<?php if (isset($_GET['deleted'])): ?>
  <div class="alert alert-success">User deleted successfully.</div>
<?php endif; ?>

<?php if (isset($_GET['toggled'])): ?>
  <div class="alert alert-info">User status updated.</div>
<?php endif; ?>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Joined On</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $u): ?>
      <tr>
        <td><?php echo e($u['id']); ?></td>
        <td><?php echo e($u['name']); ?></td>
        <td><?php echo e($u['email']); ?></td>
        <td><?php echo e($u['created_at']); ?></td>
        <td>
          <?php if ($u['is_blocked']): ?>
            <span class="badge bg-danger">Blocked</span>
          <?php else: ?>
            <span class="badge bg-success">Active</span>
          <?php endif; ?>
        </td>
        <td>
          <a class="btn btn-sm btn-warning" href="?toggle=<?php echo e($u['id']); ?>">
            <?php echo $u['is_blocked'] ? 'Unblock' : 'Block'; ?>
          </a>
          <a class="btn btn-sm btn-danger" href="?delete=<?php echo e($u['id']); ?>" onclick="return confirm('Delete this user?');">Delete</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
