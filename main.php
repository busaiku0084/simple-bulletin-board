<?php

  $dataFile = 'bbs.txt';

  function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
  }

  // 投稿機能
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && 
  isset($_POST['comment']) &&
  isset($_POST['name']) &&
  isset($_POST['password'])) {

    $name = trim($_POST['name']);
    $comment = trim($_POST['comment']);
    $password = trim($_POST['password']);
    $postedAt = date('Y/m/d H:i:s');

    if ($comment !== '') {
      $lines = file($dataFile, FILE_IGNORE_NEW_LINES);

      $name = ($name === '') ? '名無し' : $name;

      $number = count($lines);
      $number++;

      $newData = $number . "<>" . $name . "<>" . $comment . "<>" . $postedAt . "<>" . $password . "<>" . "\n";

      $fp = fopen($dataFile, 'a');
      fwrite($fp, $newData);
      fclose($fp);
    }
  }

    // 消去機能
  if ($_SERVER['REQUEST_METHOD'] == 'POST' &&
  isset($_POST['delete']) &&
  isset($_POST['delPassword'])) {

    $delete = $_POST["deleteNo"];
    $password = trim($_POST['delPassword']);

    $delLines = file($dataFile, FILE_IGNORE_NEW_LINES);
        
    $fp = fopen($dataFile, 'w');

    for ($i = 0; $i < count($delLines); $i++) {
      $delLine = explode("<>", $delLines[$i]);
      $delLineNo = $delLine[0];
      $delPassword = $delLine[4];
            
      if (($delLineNo !== $delete) && ($delPassword == $password)) { 
        fwrite($fp, $delLines[$i] . PHP_EOL);
      }
    }

    fclose($fp);
  }

  // 編集機能
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && 
  !empty($_POST['edit']) &&
  !empty($_POST['editComment']) &&
  !empty($_POST['editName']) &&
  !empty($_POST['editPassword'])) {

    $editName = trim($_POST['editName']);
    $editComment = trim($_POST['editComment']);
    
    $edit = $_POST["editNo"];
    $editPassword = $_POST['editPassword'];
    
    $editLines = file($dataFile, FILE_IGNORE_NEW_LINES);
    
    $postedAt = date('Y/m/d H:i:s');

    $fp = fopen($dataFile, 'w');

    foreach ($editLines as $editLine) {
      $str = explode("<>", $editLine);

      if ($str[0] == $edit) {
        $newData = $edit . "<>" . $editName . "<>" . $editComment . "<>" . $postedAt . "<>" . $editPassword . "<>" . "\n";
        fwrite($fp, $newData);
      }
      else {
          fwrite($fp, $editLine . PHP_EOL);
      }
    }

    fclose($fp);
    $edit = null;
  }

  $posts = file($dataFile, FILE_IGNORE_NEW_LINES);
  $posts = array_reverse($posts);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>ひとこと掲示板</title>
</head>
<body>
  <h1>ひとこと掲示板</h1>
  <form action="" method="post">
    <p>投稿</p>
    コメント: <input type="text" name="comment" placeholder="コメント"><br>
    名前: <input type="text" name="name" placeholder="なまえ"><br>
    パスワード: <input type="password" name="password" placeholder="パスワード" maxlength="10"><br>
    <input type="submit" name="post" value="投稿" style="width: 250px; margin-top: 10px">

    <p>編集</p>
    編集番号: <input type="number" name="editNo" min="1" max="" placeholder="0"><br>
    コメント: <input type="text" name="editComment" placeholder="コメント"><br>
    名前: <input type="text" name="editName" placeholder="なまえ"><br>
    パスワード: <input type="password" name="editPassword" placeholder="パスワード" maxlength="10"><br>
    <input type="submit" name="edit" value="編集" style="width: 250px; margin-top: 10px">

    <p>消去</p>
    消去番号: <input type="number" name="deleteNo" min="1" max="" placeholder="0"><br>
    パスワード: <input type="password" name="delPassword" placeholder="パスワード" maxlength="10"><br>
    <input type="submit" name="delete" value="消去" style="width: 250px; margin-top: 10px">
  </form>

  <h2>投稿（<?= count($posts); ?>件）</h2>
  <ul>
    <?php if (count($posts)) : ?>
      <?php foreach ($posts as $post) : ?>
        <?php list($number, $name, $comment, $postedAt) = explode("<>", $post); ?>
          <li>
            <?= h($number); ?> <?= h($name); ?> ( <?= h($comment); ?> ) - <?= h($postedAt); ?>
          </li>
      <?php endforeach; ?>
    <?php else : ?>
      <li>まだ投稿はありません。</li>
    <?php endif; ?>
  </ul>
</body>
</html>