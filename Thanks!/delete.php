<?php
require('dbconnect.php');
session_start();


if(isset($_SESSION['id'])){
  $id = $_REQUEST['id'];

  $messages = $db->prepare('SELECT * FROM posts WHERE id=?');
  $messages->execute(array($id));
  $message = $messages->fetch();
}else{
  header('Location: index.php');
  exit();
}

if(!empty($_POST)){
 if($message['user_id'] == $_SESSION['id']){
  $del = $db->prepare('DELETE FROM posts WHERE id=?');
  $del->execute(array($id));}

  header('Location: delete_complete.php');
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

  <title>投稿削除</title>
</head>
<body>
 <form action="" method="post">

  <h2>投稿削除</h2>
   <textarea name="message" id="" cols="30" rows="10"><?php print(htmlspecialchars($message['message'],ENT_QUOTES));?></textarea>

   <p class="delete-message">※削除してよろしいですか？</p>
   <a class="buton login" href="index.php">投稿一覧へ戻る</a>
   <input class="buton submit" type="submit" value="OK">
 </form>
</body>
</html>