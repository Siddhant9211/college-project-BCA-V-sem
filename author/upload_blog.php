<?php
require_once __DIR__ . '/../includes/header.php';
redirect_if_not_author();

$author_id = $_SESSION['author_id'];

// fetch categories
$catStmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $catStmt->fetchAll();

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $excerpt = trim($_POST['excerpt']);
    $content = trim($_POST['content']);
    $category_id = !empty($_POST['category_id']) ? intval($_POST['category_id']) : null;

    // Validate inputs
    if (empty($title) || empty($content)) {
        $error = "Please fill all required fields.";
    }

    // image upload
    $image_path = "";
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $temp_name = $_FILES['image']['tmp_name'];
        $newfilename = time() . "_" . uniqid() . "." . pathinfo($image, PATHINFO_EXTENSION);

        // Absolute path to uploads folder
        $upload_dir = __DIR__ . '/../uploads/';

        // Create folder if not exists
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $target = $upload_dir . $newfilename;

        if (move_uploaded_file($temp_name, $target)) {
            $image_path = "uploads/" . $newfilename;
        } else {
            $error = "❌ Image upload failed.";
        }
    }

    if (empty($error)) {
        $stmt = $pdo->prepare("INSERT INTO blogs (author_id, title, excerpt, content, image, category_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$author_id, $title, $excerpt, $content, $image_path, $category_id]);
        $success = "✅ Blog created successfully.";
    }
}
?>

<h2>Create New Blog</h2>
<?php if(!empty($error)): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>
<?php if(!empty($success)): ?><div class="alert alert-success"><?php echo e($success); ?></div><?php endif; ?>

<form method="post" enctype="multipart/form-data">
  <div class="mb-3"><label>Title</label><input class="form-control" name="title" required></div>
  <div class="mb-3"><label>Excerpt (short)</label><input class="form-control" name="excerpt"></div>
  <div class="mb-3"><label>Content</label><textarea class="form-control" name="content" rows="8" required></textarea></div>
  <div class="mb-3"><label>Category</label>
    <select class="form-control" name="category_id">
      <option value="">--Select Category--</option>
      <?php foreach($categories as $c): ?>
        <option value="<?php echo e($c['id']); ?>"><?php echo e($c['name']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3"><label>Image (optional)</label><input class="form-control" type="file" name="image" accept="image/*"></div>
  <button class="btn btn-success">Publish</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
