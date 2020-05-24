<?php
require('dbconnect.php');
session_start();

$user_id = $_REQUEST['id'];

$user_pictures = $db->prepare('SELECT * FROM users  WHERE id=?');
$user_pictures -> execute(array($user_id));
$user = $user_pictures->fetch(); 

$posts = $db->prepare('SELECT * FROM posts WHERE user_id=?');
$posts->execute(array($user_id));

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="new_check.css">
  <title>ユーザーページ</title>
</head>

<body>
 <div class="user">
   <img id="user-picture" src="user_picture/<?php print(htmlspecialchars($user['picture'],ENT_QUOTES));?>" alt="ユーザー画像">

   <p class="user-name"><?php print(htmlspecialchars($user['name']));?></p>
   <p class="city"><?php print(htmlspecialchars($user['city'],ENT_QUOTES));?></p>

   <?php if($_SESSION['id'] == $user['id']):?> 
    <a href="user_update.php?id=<?php print(htmlspecialchars($user['id']));?>">ユーザー情報を編集する</a>
    <a href="user_delete.php?id=<?php print(htmlspecialchars($user['id']));?>">ユーザーアカウントを削除する</a>
   <?php endif;?>
  </div>

 
 
 <h2 class="posted">投稿履歴</h2>
  <?php foreach($posts as $post):?> 
   <p class="message"><?php print(htmlspecialchars($post['message'],ENT_QUOTES));?></p>

  <?php if($_SESSION['id'] == $post['user_id']):?> 
   <a class="delete" href="delete.php?id=<?php print(htmlspecialchars($post['id'],ENT_QUOTES));?>">投稿を削除する</a><br>
   
   <a class="buton rewrite" href="rewrite.php?id=<?php print(htmlspecialchars($post['id'],ENT_QUOTES));?>">投稿内容を変更する</a>
   <?php endif;?>
   

  <?php endforeach;?>
  

 
</body>
</html>