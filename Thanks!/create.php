<?php
require('dbconnect.php');
session_start();

if(isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()){

}else{
  header('Location: login.php');}


if(!empty($_POST)){
  if($_POST['message'] !== ''){
    $_SESSION['message'] = $_POST['message'];
    header('Location: create_check.php');
  }else{
    $error['message'] = 'blank';
  }
}

/*create_checkより投稿内容変更で戻ってきた時の処理 */
if($_REQUEST['action'] == 'rewrite' && isset($_SESSION['message'])){
  $_POST['message'] = $_SESSION['message'];
}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="new_check.css">
  <title>投稿ページ</title>
</head>
<body>

<h2>ありがとうを伝えてみましょう！</h2>
<form action="" method="post">
 <textarea name="message" id="" cols="50" rows="10" maxlength="150" placeholder="１５０文字以内でご記入お願いします"><?php print(htmlspecialchars($_POST['message'],ENT_QUOTES));?></textarea><br>
 
 <?php if($error['message'] === 'blank'):?>
 <p>※投稿内容を入力してください</p>
 <?php endif;?>
 
 <a class="buton rewrite" href="index.php">投稿一覧へ戻る</a>
  <input class="buton submit" type="submit" value="投稿内容を確認する">

</form>
</body>
</html>