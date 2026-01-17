<?php
require_once __DIR__ . '/../includes/header.php';
redirect_if_not_admin();

// Fetch all blogs with author names
$stmt = $pdo->query("
  SELECT b.id, b.title, b.excerpt, b.image, b.created_at,
         a.name AS author_name, c.name AS category
  FROM blogs b
  LEFT JOIN authors a ON b.author_id = a.id
  LEFT JOIN categories c ON b.category_id = c.id
  ORDER BY b.created_at DESC
");
$blogs = $stmt->fetchAll();

// Delete blog if requested
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM blogs WHERE id = ?");
    $stmt->execute([$delete_id]);
    header("Location: manage_blogs.php?deleted=1");
    exit;
}
?>

<h2>Manage Blogs</h2>

<?php if (isset($_GET['deleted'])): ?>
  <div class="alert alert-success">Blog deleted successfully.</div>
<?php endif; ?>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>Title</th>
      <th>Author</th>
      <th>Category</th>
      <th>Image</th>
      <th>Created At</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($blogs as $b): ?>
      <tr>
        <td><?php echo e($b['id']); ?></td>
        <td><?php echo e($b['title']); ?></td>
        <td><?php echo e($b['author_name'] ?? 'Unknown'); ?></td>
        <td><?php echo e($b['category'] ?? 'Uncategorized'); ?></td>
        <td>
          <?php if ($b['image']): ?>
            <img src="/Vishw-Vidya/<?php echo e($b['image']); ?>" width="80">
          <?php else: ?>
            No Image
          <?php endif; ?>
        </td>
        <td><?php echo e($b['created_at']); ?></td>
        <td>
          <a class="btn btn-sm btn-danger" href="?delete=<?php echo e($b['id']); ?>" onclick="return confirm('Delete this blog?');">Delete</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
