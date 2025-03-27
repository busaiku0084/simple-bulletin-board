<?php
require_once __DIR__ . '/../functions.php';

$id = $_GET['id'] ?? null;

if (is_numeric($id)) {
    delete_message((int)$id);
}

header('Location: index.php');
exit;
