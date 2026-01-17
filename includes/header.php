<?php
// includes/header.php
require_once __DIR__ . '/functions.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Vishw-Vidya</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap (optional but useful for layout) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   
  <!-- Custom CSS -->
  <link href="/Vishw-Vidya/assets/css/style.css" rel="stylesheet">

  <!-- ✅ Your Custom CSS -->
  <link rel="stylesheet" href="/Vishw-Vidya/assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-primary" href="/Vishw-Vidya/index.php">Vishw-Vidya</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item"><a class="nav-link" href="/Vishw-Vidya/index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/Vishw-Vidya/all_blogs.php">Blogs</a></li>
        <li class="nav-item"><a class="nav-link" href="/Vishw-Vidya/login_selection.php">Login</a></li>

        <?php if(is_logged_in_author()): ?>
          <li class="nav-item"><a class="nav-link" href="/Vishw-Vidya/author/dashboard.php">Author Dashboard</a></li>
          <li class="nav-item"><a class="nav-link text-danger" href="/Vishw-Vidya/author/logout.php">Logout</a></li>
        <?php endif; ?>

        <?php if(is_logged_in_user()): ?>
          <li class="nav-item"><a class="nav-link text-danger" href="/Vishw-Vidya/user/logout.php">Logout</a></li>
        <?php endif; ?>

        <?php if(is_logged_in_admin()): ?>
          <li class="nav-item"><a class="nav-link" href="/Vishw-Vidya/admin/dashboard.php">Admin</a></li>
          <li class="nav-item"><a class="nav-link text-danger" href="/Vishw-Vidya/admin/logout.php">Logout</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="container page-container">
