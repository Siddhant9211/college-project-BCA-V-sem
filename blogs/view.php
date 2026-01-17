<?php
require_once __DIR__ . '/../includes/header.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $pdo->prepare("SELECT b.*, a.name as author_name, c.name as category_name FROM blogs b LEFT JOIN authors a ON b.author_id = a.id LEFT JOIN categories c ON b.category_id = c.id WHERE b.id = ?");
$stmt->execute([$id]);
$b = $stmt->fetch();
if (!$b) {
    echo "<div class='alert alert-danger mt-5 text-center'>Blog not found.</div>";
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

// comment submission (user only)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    if (!isset($_SESSION['user_id'])) {
        $error = "You must be logged in as a user to comment.";
    } else {
        $comment = trim($_POST['comment']);
        if ($comment) {
            $stmt = $pdo->prepare("INSERT INTO comments (blog_id, user_id, comment) VALUES (?, ?, ?)");
            $stmt->execute([$id, $_SESSION['user_id'], $comment]);
            $success = "Comment added.";
        }
    }
}

// fetch comments
$cm = $pdo->prepare("SELECT com.*, u.name as user_name FROM comments com JOIN users u ON com.user_id = u.id WHERE com.blog_id = ? ORDER BY com.created_at DESC");
$cm->execute([$id]);
$comments = $cm->fetchAll();
?>

<section class="single-blog my-5">
  <div class="blog-header text-center mb-4">
    <h2 class="fw-bold blog-title"><?php echo e($b['title']); ?></h2>
    <p class="text-muted small">
      By <strong><?php echo e($b['author_name']); ?></strong> • 
      <em><?php echo e($b['category_name']); ?></em> • 
      <?php echo date('F j, Y', strtotime($b['created_at'])); ?>
    </p>
  </div>

  <?php if($b['image']): ?>
    <div class="blog-image mb-4 text-center">
      <img src="/Vishw-Vidya/uploads/<?php echo e($b['image']); ?>" alt="<?php echo e($b['title']); ?>">
    </div>
  <?php endif; ?>

  <div class="blog-content mb-5">
    <p><?php echo nl2br(e($b['content'])); ?></p>
  </div>

  <hr class="mb-4">

  <section class="comments-section">
    <h5 class="fw-bold mb-3">Comments</h5>
    <?php if(!empty($error)): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>
    <?php if(!empty($success)): ?><div class="alert alert-success"><?php echo e($success); ?></div><?php endif; ?>

    <?php if(isset($_SESSION['user_id'])): ?>
      <form method="post" class="comment-form mb-4">
        <textarea name="comment" class="form-control" rows="3" placeholder="💬 Write your comment..."></textarea>
        <button class="btn btn-primary mt-2 px-4 rounded-pill">Post Comment</button>
      </form>
    <?php else: ?>
      <div class="alert alert-info">Please <a href="/Vishw-Vidya/user/login.php" class="text-decoration-none">login as user</a> to comment.</div>
    <?php endif; ?>

    <?php if($comments): foreach($comments as $c): ?>
      <div class="card comment-card mb-3 border-0 shadow-sm">
        <div class="card-body">
          <p class="mb-1"><?php echo e($c['comment']); ?></p>
          <small class="text-muted">— <?php echo e($c['user_name']); ?> • <?php echo date('F j, Y, g:i a', strtotime($c['created_at'])); ?></small>
        </div>
      </div>
    <?php endforeach; else: ?>
      <div class="text-muted">No comments yet. Be the first to share your thoughts!</div>
    <?php endif; ?>
  </section>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
