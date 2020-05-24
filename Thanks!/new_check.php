<?php
require('dbconnect.php');
session_start();


if(!isset($_SESSION)){
  header('Location: index.php');}

if(!empty($_POST)){
  $statement = $db->prepare('INSERT INTO users SET name=?,email=?,password=?,picture=?,city=?,created_day=NOW()');
  echo $statement->execute(array($_SESSION['join']['name'],
                                 $_SESSION['join']['email'],
                                 sha1($_SESSION['join']['password']),
                                 $_SESSION['join']['image'],
                                 $_SESSION['join']['city']));

  unset($_SESSION['join']);

  header('Location: new_complete.php');
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
  <title>登録内容確認</title>
</head>
<body>
<form action="" method="post">
<input type="hidden" name="action" value="submit">

  <h2>登録内容をご確認ください</h2>
  
    <li> ニックネーム</li>
      <p><?php print(htmlspecialchars($_SESSION['join']['name'],ENT_QUOTES));?></p>

    <li>メールアドレス</li>
      <p><?php print(htmlspecialchars($_SESSION['join']['email'],ENT_QUOTES));?></p>

    <li>お住まいの地域</li>
       <p><?php print(htmlspecialchars($_SESSION['join']['city'],ENT_QUOTES));?></p>

    <li>プロフィール写真</li>
       <?php if($_SESSION['join']['image'] !== ''):?>
       <img src="user_picture/<?php print(htmlspecialchars($_SESSION['join']['image'],ENT_QUOTES));?>">
       <?php endif;?><br>

  
  <a class="buton rewrite" href="new.php? action=rewrite">入力内容を訂正する</a><input class="buton submit" type="submit" value="登録する">
  </form>
</body>
</html>