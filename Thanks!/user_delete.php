<?php
require('dbconnect.php');
session_start();


$user_id = $_REQUEST['id'];

$user_pictures = $db->prepare('SELECT * FROM users WHERE id=?');
$user_pictures -> execute(array($user_id));
$user = $user_pictures->fetch(); 

if(isset($_POST['user_delete'])){
  if($_SESSION['id'] == $user_id){
  $user_del = $db->prepare('DELETE FROM users WHERE id=?');
  $user_del->execute(array($user_id));}

  header('Location: user_delete_complete.php');
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
  <title>ユーザーアカウント削除</title>
</head>
<body>

<form action="" method="post">
<div class="user">
   <img id="user-picture" src="user_picture/<?php print(htmlspecialchars($user['picture'],ENT_QUOTES));?>" alt="ユーザー画像">

   <p class="user-name"><?php print(htmlspecialchars($user['name']));?></p>
   <p class="city"><?php print(htmlspecialchars($user['city'],ENT_QUOTES));?></p>

   <h3 class="delete-message">※ユーザーアカウントを削除してもよろしいですか？</h3>

   <a class="buton login" href="user_page.php?id=<?php print(htmlspecialchars($user['id'],ENT_QUOTES));?>">ユーザーページへ戻る</a>
   <input class="buton submit" type="submit" name="user_delete" value="削除する">
</form> 
</body>
</html>