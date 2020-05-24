<?php
require('dbconnect.php');
session_start();


if(isset($_SESSION['id'])){
  $posts_id = $_REQUEST['id'];
  
  $posts = $db->prepare('SELECT * FROM posts WHERE id=?');
  $posts->execute(array($posts_id));
  $post_id = $posts->fetch();
 
}else{
  header('Location: index.php');
  exit();
}

if(isset($_POST['rewrite-check'])){
  if($_POST['message'] !== ''){
    $_SESSION['message'] = $_POST['message'];
    $_SESSION['posts_id'] = $posts_id;
    header("Location: rewrite_check.php?id=".$_SESSION[posts_id]);
  }else{
    $error['message'] = 'blank';
  }
}



?>



<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="new_check.css">
  <title>投稿内容変更</title>
</head>
<body>

<h2>投稿内容を変更</h2>
<form action="" method="post">
 <textarea name="message" id="" cols="50" rows="10" maxlength="150" placeholder="１５０文字以内でご記入お願いします"><?php print(htmlspecialchars($post_id['message'],ENT_QUOTES));?></textarea><br>
 
 <?php if($error['message'] === 'blank'):?>
 <p class="error">※投稿内容を入力してください</p>
 <?php endif;?>
 
 <a class="buton rewrite" href="index.php">投稿一覧へ戻る</a>
  <input class="buton submit" type="submit" name="rewrite-check" value="修正内容を確認する">

</form>
</body>
</html>