<?php
require_once __DIR__ . '/includes/header.php';

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$category = isset($_GET['category']) ? trim($_GET['category']) : '';

$sql = "SELECT b.*, a.name as author_name, c.name as category_name FROM blogs b 
        LEFT JOIN authors a ON b.author_id = a.id
        LEFT JOIN categories c ON b.category_id = c.id
        WHERE 1=1 ";

$params = [];
if ($q) {
    $sql .= " AND (b.title LIKE ? OR b.content LIKE ? OR a.name LIKE ?)";
    $like = "%$q%";
    $params[] = $like; $params[] = $like; $params[] = $like;
}
if ($category) {
    $sql .= " AND c.name = ?";
    $params[] = $category;
}
$sql .= " ORDER BY b.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$blogs = $stmt->fetchAll();
?>
<center>
<h2 >All Blogs</h2>
</center>
<?php if(!$blogs): ?>
  <div class="alert alert-info">No blogs found.</div>
<?php else: ?>
  <div class="row">
    <?php foreach($blogs as $b): ?>
      <div class="col-md-4 mb-3">
        <div class="card">
          <?php if($b['image']): ?>
            <img src="/Vishw-Vidya/uploads/<?php echo e($b['image']); ?>" class="card-img-top" style="height:180px; object-fit:cover;">
          <?php endif; ?>
          <div class="card-body">
            <h5 class="card-title"><?php echo e($b['title']); ?></h5>
            <p class="card-text"><?php echo e($b['excerpt'] ?: substr($b['content'],0,120) . '...'); ?></p>
            <p class="small text-muted">By <?php echo e($b['author_name']); ?> • <?php echo e($b['category_name']); ?></p>
            <a class="btn btn-primary btn-sm" href="/Vishw-Vidya/blogs/view.php?id=<?php echo $b['id']; ?>">Read</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
