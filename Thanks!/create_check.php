<?php
require('dbconnect.php');
session_start();

if(!isset($_SESSION['message'])){
  header('Location: login.php');
  exit();
}

if(!empty($_POST)){
  $messages = $db->prepare('INSERT INTO posts SET user_id=?,message=?,create_time=NOW()');
  $messages->execute(array($_SESSION['id'],$_SESSION['message']));
  
  unset($_SESSION['message']);
  header('Location: create_complete.php');
  exit();

}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="new_check.css">
  <title>投稿内容確認</title>
</head>
<body>
  <h2>投稿内容を確認する</h2>
  <form action="" method="post">
  <input type="hidden" name="action" value="submit">
  
  <p><?php print(htmlspecialchars($_SESSION['message'],ENT_QUOTES));?></p><br>

 <a class="buton rewrite" href="create.php? action=rewrite">投稿内容を変更する</a><input class="buton submit" type="submit" value="投稿する">

</form>
</body>
</html>