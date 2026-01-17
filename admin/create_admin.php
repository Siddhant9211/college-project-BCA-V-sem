<?php
// admin/create_admin.php
require_once __DIR__ . '/../includes/db.php';

// Change username and password here before running:
$username = 'admin';
$password = 'Admin@123';

// check exists
$stmt = $pdo->prepare("SELECT id FROM admins WHERE username = ?");
$stmt->execute([$username]);
if ($stmt->fetch()) {
    echo "Admin already exists. Delete this file for security.";
    exit;
}
$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
$stmt->execute([$username, $hash]);
echo "Admin created. Username: $username , Password: $password<br>Delete create_admin.php now for security.";
