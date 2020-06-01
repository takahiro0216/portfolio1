<?php
require('dbconnect.php');
session_start();

$user_id = $_REQUEST['id'];

if($_SESSION['id'] == $user_id){
  $users = $db->prepare('SELECT * FROM users WHERE id=?');
  $users->execute(array($user_id));
  $user = $users->fetch();
 
}



if(isset($_POST['update-buton']) && isset($_SESSION['update']['new-image'])){
  $userUpdate = $db->prepare('UPDATE users SET name=?,email=?,city=?,picture=? WHERE id=?');
  $userUpdate->execute(array($_SESSION['update']['name'],$_SESSION['update']['email'],$_SESSION['update']['city'],$_SESSION['update']['new-image'],$user_id));
  header('Location: user_update_complete.php');
  exit();
}

if(isset($_POST['update-buton']) && !isset($_SESSION['update']['new-image'])){
  $userUpdate = $db->prepare('UPDATE users SET name=?,email=?,city=? WHERE id=?');
  $userUpdate->execute(array($_SESSION['update']['name'],$_SESSION['update']['email'],$_SESSION['update']['city'],$user_id));
  header('Location: user_update_complete.php');
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
  <title>編集内容確認</title>
</head>
<body>
  
<form action="" method="post">
<input type="hidden" name="action" value="submit">

  <h2>登録内容をご確認ください</h2>
  
    <li> ニックネーム</li>
      <p><?php print(htmlspecialchars($_SESSION['update']['name'],ENT_QUOTES));?></p>

    <li>メールアドレス</li>
      <p><?php print(htmlspecialchars($_SESSION['update']['email'],ENT_QUOTES));?></p>

    <li>お住まいの地域</li>
      <?php if(!empty($_SESSION['update']['city'])):?>
       <p><?php print(htmlspecialchars($_SESSION['update']['city'],ENT_QUOTES))?></p>
      <?php else:?>
       <p><?php print(htmlspecialchars($user['city'],ENT_QUOTES))?></p>
      <?php endif;?>


    <li>プロフィール写真</li>
       <?php if(isset($_SESSION['update']['new-image'])):?>
        <img src="user_picture/<?php print(htmlspecialchars($_SESSION['update']['new-image'],ENT_QUOTES))?>"> 
       <?php else:?>
      <img src="user_picture/<?php print(htmlspecialchars($user['picture'],ENT_QUOTES));?>" >
       <?php endif;?>


  
  <a class="buton rewrite" href="user_update.php?id=<?php print(htmlspecialchars($user_id,ENT_QUOTES));?>">入力内容を訂正する</a><input class="buton submit" type="submit" name="update-buton" value="登録する">
  </form>
</body>
</html>