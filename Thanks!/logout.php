<?php
session_start();


$_SESSION = array();
if(ini_set('session.use_cookie')){
  $params = session_get_cookie_params();
  setcookie(session_name(). '' , time() -42000, $params['path'],$params['domain'],$params['secure'],$params['httponly']);
}

session_destroy();
setcookie('email' , '' , -3600);

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="new_check.css">
  <title>ログアウト</title>
</head>
<body>
  
  <h2>ログアウトしました！いつでもお待ちしております！</h2>

<a class="buton login" href="login.php">ログインへ戻る</a>

</body>
</html>