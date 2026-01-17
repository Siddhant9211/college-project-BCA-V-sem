<?php
// includes/functions.php
session_start();
require_once __DIR__ . '/db.php';

function is_logged_in_user() {
    return isset($_SESSION['user_id']);
}
function is_logged_in_author() {
    return isset($_SESSION['author_id']);
}
function is_logged_in_admin() {
    return isset($_SESSION['admin_id']);
}

function redirect_if_not_author() {
    if (!is_logged_in_author()) {
        header("Location: /Vishw-Vidya/author/login.php");
        exit;
    }
}

function redirect_if_not_user() {
    if (!is_logged_in_user()) {
        header("Location: /Vishw-Vidya/user/login.php");
        exit;
    }
}

function redirect_if_not_admin() {
    if (!is_logged_in_admin()) {
        header("Location: /Vishw-Vidya/admin/login.php");
        exit;
    }
}

// escape output
function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
