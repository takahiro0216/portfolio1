<?php
require('dbconnect.php');
session_start();

/*cookieにemailが保存されている時にログインがめんを開いた時の処理 */
if(!empty($_COOKIE['email'])){
  $email = $_COOKIE['email'];
}


if(!empty($_POST)){
 $email = $_POST['email'];

 if(empty($_POST['email'])){
  $error['email'] = 'blank';
 }

 if(empty($_POST['password'])){
  $error['password'] = 'blank';
 }

 if($_POST['email']!=='' && $_POST['password']!==''){
    $login = $db->prepare('SELECT * FROM users WHERE email=? AND password=?');
    $login->execute(array($_POST['email'],sha1($_POST['password'])));
    $member = $login->fetch();

    if($member){
      $_SESSION['id'] = $member['id'];
      $_SESSION['time'] = time();

      if($_POST['save'] === 'on'){
        setcookie('email',$_POST['email'],time()+60*60*24*14);
      }

      header('Location: index.php');
      exit();
   }else{
     $error['login'] = 'failed';
   }
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
  <title>ログイン</title>
</head>

<body>
<h1>ログイン</h1>

<form action="" method="post" >

<?php if($error['login'] === 'failed'):?>
<p class="error">＊メールアドレスまたはパスワードが正しくありません。再度ご確認お願い致します</p>
<?php endif;?>

<p>メールアドレス</p>
 <input class="form" type="text" name="email" value="<?php print(htmlspecialchars($email,ENT_QUOTES));?>">
 <?php if($error['email'] === 'blank'):?>
 <p class="error">＊メールアドレスを入力してください</p>
 <?php endif;?>


<p>パスワード</p>
<input class="form" type="password" name="password">
<?php if($error['password'] === 'blank'):?>
 <p class="error">＊パスワードを入力してください</p>
 <?php endif;?><br>

<input class="check-box" id="save" type="checkbox" name="save" value="on">
 <label for="save">次回からメールアドレスを自動入力する</label><br>
<input class="buton login" type="submit" value="ログイン"><br>

<a class="buton new" href="new.php">新規登録がまだの方はこちらへどうぞ！</a>


</form>




  
</body>
</html>