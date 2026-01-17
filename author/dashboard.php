<?php
require_once __DIR__ . '/../includes/header.php';
redirect_if_not_author();

$author_id = $_SESSION['author_id'];

// Fetch author's blogs
$stmt = $pdo->prepare("SELECT b.*, c.name as category_name FROM blogs b LEFT JOIN categories c ON b.category_id = c.id WHERE b.author_id = ? ORDER BY b.created_at DESC");
$stmt->execute([$author_id]);
$blogs = $stmt->fetchAll();
?>
<h2>Your Author Dashboard</h2>
<p>Welcome, <?php echo e($_SESSION['author_name']); ?>. <a href="upload_blog.php" class="btn btn-success btn-sm">Create New Blog</a></p>

<h4>Your Blogs</h4>
<?php if(!$blogs): ?>
  <div class="alert alert-info">You have not created any blogs yet.</div>
<?php else: ?>
  <table class="table">
    <thead><tr><th>Title</th><th>Category</th><th>Created</th><th>Actions</th></tr></thead>
    <tbody>
      <?php foreach($blogs as $b): ?>
      <tr>
        <td><?php echo e($b['title']); ?></td>
        <td><?php echo e($b['category_name']); ?></td>
        <td><?php echo e($b['created_at']); ?></td>
        <td>
          <a class="btn btn-sm btn-primary" href="/Vishw-Vidya/blogs/view.php?id=<?php echo $b['id']; ?>" target="_blank">View</a>
          <a class="btn btn-sm btn-warning" href="edit_blog.php?id=<?php echo $b['id']; ?>">Edit</a>
          <a class="btn btn-sm btn-danger" href="delete_blog.php?id=<?php echo $b['id']; ?>" onclick="return confirm('Delete this blog?')">Delete</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
