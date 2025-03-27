<?php
require_once __DIR__ . '/../functions.php';

$messages = read_messages();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>シンプル掲示板</title>
  <style>
    body {
      font-family: sans-serif;
      padding: 20px;
    }

    form,
    .message {
      margin-bottom: 20px;
    }

    .message {
      border-bottom: 1px solid #ccc;
      padding: 10px 0;
    }

    .message time {
      color: #666;
      font-size: 0.9em;
    }
  </style>
</head>

<body>
  <h1>🐘 シンプル掲示板</h1>

  <form action="post.php" method="post">
    <label>名前: <input type="text" name="name" required></label><br><br>
    <label>メッセージ:<br>
      <textarea name="message" rows="4" cols="50" required></textarea>
    </label><br><br>
    <button type="submit">投稿する</button>
  </form>

  <h2>📬 投稿一覧</h2>
  <?php if (empty($messages)): ?>
    <p>まだ投稿はありません。</p>
  <?php else: ?>
    <?php foreach (array_reverse($messages, true) as $index => $line): ?>
      <?php
      list($timestamp, $name, $msg) = explode("\t", $line);
      $datetime = date('Y-m-d H:i:s', (int)$timestamp);
      ?>
      <div class="message">
        <strong><?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></strong> さん<br>
        <?= nl2br(htmlspecialchars($msg, ENT_QUOTES, 'UTF-8')) ?><br>
        <time><?= $datetime ?></time><br>
        <a href="edit.php?id=<?= $index ?>">[編集]</a>
        <a href="delete.php?id=<?= $index ?>" onclick="return confirm('削除しますか？');">[削除]</a>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</body>

</html>
