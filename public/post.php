<?php
require_once __DIR__ . '/../functions.php';

$name = trim($_POST['name'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name && $message) {
    save_message($name, $message);
}

header('Location: index.php');
exit;
