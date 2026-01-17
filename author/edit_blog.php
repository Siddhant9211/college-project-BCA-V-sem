<?php
require_once __DIR__ . '/../includes/header.php';
redirect_if_not_author();
$author_id = $_SESSION['author_id'];

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = ? AND author_id = ?");
$stmt->execute([$id, $author_id]);
$blog = $stmt->fetch();
if (!$blog) {
    echo "<div class='alert alert-danger'>Blog not found or you don't have permission.</div>";
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

// categories
$catStmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $catStmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $excerpt = trim($_POST['excerpt']);
    $content = trim($_POST['content']);
    $category_id = !empty($_POST['category_id']) ? intval($_POST['category_id']) : null;

    // image upload
    if (!empty($_FILES['image']['name'])) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
        $target = __DIR__ . '/../uploads/' . $imageName;
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $error = "Failed to upload image.";
        } else {
            // delete old image if exists
            if ($blog['image'] && file_exists(__DIR__ . '/../uploads/' . $blog['image'])) {
                @unlink(__DIR__ . '/../uploads/' . $blog['image']);
            }
        }
    } else {
        $imageName = $blog['image'];
    }

    if (!$error) {
        $stmt = $pdo->prepare("UPDATE blogs SET title=?, excerpt=?, content=?, image=?, category_id=?, updated_at = NOW() WHERE id = ? AND author_id = ?");
        $stmt->execute([$title, $excerpt, $content, $imageName, $category_id, $id, $author_id]);
        $success = "Blog updated.";
        // refresh blog data
        $stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = ?");
        $stmt->execute([$id]);
        $blog = $stmt->fetch();
    }
}
?>
<h2>Edit Blog</h2>
<?php if(!empty($error)): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>
<?php if(!empty($success)): ?><div class="alert alert-success"><?php echo e($success); ?></div><?php endif; ?>

<form method="post" enctype="multipart/form-data">
  <div class="mb-3"><label>Title</label><input class="form-control" name="title" value="<?php echo e($blog['title']); ?>" required></div>
  <div class="mb-3"><label>Excerpt</label><input class="form-control" name="excerpt" value="<?php echo e($blog['excerpt']); ?>"></div>
  <div class="mb-3"><label>Content</label><textarea class="form-control" name="content" rows="8" required><?php echo e($blog['content']); ?></textarea></div>
  <div class="mb-3"><label>Category</label>
    <select class="form-control" name="category_id">
      <option value="">--Select Category--</option>
      <?php foreach($categories as $c): ?>
        <option value="<?php echo e($c['id']); ?>" <?php if($blog['category_id']==$c['id']) echo 'selected'; ?>><?php echo e($c['name']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label>Image (upload to replace)</label>
    <?php if($blog['image']): ?>
      <div><img src="/Vishw-Vidya/uploads/<?php echo e($blog['image']); ?>" style="max-width:200px"></div>
    <?php endif; ?>
    <input class="form-control" type="file" name="image" accept="image/*">
  </div>
  <button class="btn btn-primary">Update</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
