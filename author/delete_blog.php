<?php
require_once __DIR__ . '/../includes/functions.php';
redirect_if_not_author();
$author_id = $_SESSION['author_id'];

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = ? AND author_id = ?");
$stmt->execute([$id, $author_id]);
$blog = $stmt->fetch();

if ($blog) {
    // delete image file
    if ($blog['image'] && file_exists(__DIR__ . '/../uploads/' . $blog['image'])) {
        @unlink(__DIR__ . '/../uploads/' . $blog['image']);
    }
    $stmt = $pdo->prepare("DELETE FROM blogs WHERE id = ? AND author_id = ?");
    $stmt->execute([$id, $author_id]);
}
header("Location: /Vishw-Vidya/author/dashboard.php");
exit;
