<?php
require_once __DIR__ . '/../includes/header.php';
redirect_if_not_admin();

// Handle author delete
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM authors WHERE id = ?");
    $stmt->execute([$delete_id]);
    header("Location: manage_authors.php?deleted=1");
    exit;
}

// Handle author block/unblock
if (isset($_GET['toggle'])) {
    $toggle_id = intval($_GET['toggle']);
    $stmt = $pdo->prepare("SELECT is_blocked FROM authors WHERE id = ?");
    $stmt->execute([$toggle_id]);
    $author = $stmt->fetch();

    if ($author) {
        $new_status = $author['is_blocked'] ? 0 : 1;
        $stmt = $pdo->prepare("UPDATE authors SET is_blocked = ? WHERE id = ?");
        $stmt->execute([$new_status, $toggle_id]);
        header("Location: manage_authors.php?toggled=1");
        exit;
    }
}

// Fetch all authors
$stmt = $pdo->query("SELECT * FROM authors ORDER BY created_at DESC");
$authors = $stmt->fetchAll();
?>

<h2>Manage Authors</h2>

<?php if (isset($_GET['deleted'])): ?>
  <div class="alert alert-success">Author deleted successfully.</div>
<?php endif; ?>

<?php if (isset($_GET['toggled'])): ?>
  <div class="alert alert-info">Author status updated.</div>
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
    <?php foreach ($authors as $a): ?>
      <tr>
        <td><?php echo e($a['id']); ?></td>
        <td><?php echo e($a['name']); ?></td>
        <td><?php echo e($a['email']); ?></td>
        <td><?php echo e($a['created_at']); ?></td>
        <td>
          <?php if ($a['is_blocked']): ?>
            <span class="badge bg-danger">Blocked</span>
          <?php else: ?>
            <span class="badge bg-success">Active</span>
          <?php endif; ?>
        </td>
        <td>
          <a class="btn btn-sm btn-warning" href="?toggle=<?php echo e($a['id']); ?>">
            <?php echo $a['is_blocked'] ? 'Unblock' : 'Block'; ?>
          </a>
          <a class="btn btn-sm btn-danger" href="?delete=<?php echo e($a['id']); ?>" onclick="return confirm('Delete this author?');">Delete</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
