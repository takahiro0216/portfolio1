<?php
session_start();
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="new_check.css">

  <title>ユーザー情報変更完了！</title>
</head>
<body>
<h2>投稿内容の修正が完了しました！</h2>

<a href="user_page.php?id=<?php print(htmlspecialchars($_SESSION['id'],ENT_QUOTES));?>">ユーザーページへ戻る</a>
</body>
</html>