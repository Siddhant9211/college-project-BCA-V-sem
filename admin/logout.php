<?php
require_once __DIR__ . '/../includes/functions.php';
session_unset();
session_destroy();
header("Location: /Vishw-Vidya/index.php");
exit;
