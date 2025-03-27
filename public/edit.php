<?php
require_once __DIR__ . '/../functions.php';

$id = $_GET['id'] ?? null;
$messages = read_messages();

if (!is_numeric($id) || !isset($messages[$id])) {
    header('Location: index.php');
    exit;
}

list($timestamp, $name, $msg) = explode("\t", $messages[$id]);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>編集 - 掲示板</title>
</head>

<body>
    <h1>✏️ 投稿編集</h1>
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <label>名前: <input type="text" name="name" value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>" required></label><br><br>
        <label>メッセージ:<br>
            <textarea name="message" rows="4" cols="50" required><?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?></textarea>
        </label><br><br>
        <button type="submit">更新</button>
    </form>
    <p><a href="index.php">← 戻る</a></p>
</body>

</html>
