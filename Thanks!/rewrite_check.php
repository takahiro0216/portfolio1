<?php
require('dbconnect.php');
session_start();

$posts_id = $_REQUEST['id'];

if(!isset($_SESSION['message'])){
  header('Location: login.php');
  exit();
}


if(isset($_POST['post_rewrite'])){
  $statement = $db->prepare('UPDATE posts SET message=? WHERE id=?');
  $statement->execute(array($_SESSION['message'],$_SESSION['posts_id']));

  unset($_SESSION['re-message'],$_SESSION['posts_id']);
  header('Location: rewrite_complete.php');
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
  <title>修正内容確認</title>
</head>
<body>
  <h2>修正内容を確認する</h2>
  <form action="" method="post">
  
  <p><?php print(htmlspecialchars($_SESSION['message'],ENT_QUOTES));?></p><br>

 

 <a class="buton rewrite" href="rewrite.php?id=<?php print(htmlspecialchars($posts_id,ENT_QUOTES));?>">修正画面に戻る</a>
 
 <input class="buton submit" type="submit" name="post_rewrite" value="修正完了する">

</form>
</body>
</html>