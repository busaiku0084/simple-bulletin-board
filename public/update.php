<?php
require_once __DIR__ . '/../functions.php';

$id = $_POST['id'] ?? null;
$name = trim($_POST['name'] ?? '');
$message = trim($_POST['message'] ?? '');

if (is_numeric($id) && $name && $message) {
    update_message((int)$id, $name, $message);
}

header('Location: index.php');
exit;
