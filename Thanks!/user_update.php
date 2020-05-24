<?php
require('dbconnect.php');
session_start();

$user_id = $_REQUEST['id'];

if($_SESSION['id'] == $user_id){
  $users = $db->prepare('SELECT * FROM users WHERE id=?');
  $users->execute(array($user_id));
  $user = $users->fetch();
}

/**エラーに関するコード **/
if(!empty($_POST)){

  if(empty($_POST['name'])){
    $error['name'] = 'blank';}
      
  if(empty($_POST['email'])){
     $error['email'] ='blank';}
   
   $fileName = $_FILES['new-image']['name'];
   if(!empty($fileName)){
    $ext = substr($fileName, -3);
     if($ext != 'jpg' && $ext != 'gif' && $ext != 'png'){
         $error['image'] = 'type';
       }  
    }
    
  }

 /**編集内容確認ボタン押した時の処理 */   
 if(isset($_POST['update-check'])){
   if(empty($error)){
    $image = date('YmdHis'). $_FILES['new-image']['name'];
    move_uploaded_file($_FILES['new-image']['tmp_name'],'user_picture/'. $image); 

    $_SESSION['update'] = $_POST;
    $_SESSION['update']['new-image'] = $image;

   header("Location: user_update_check.php?id=".$user['id']);
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
  <title>ユーザー情報を編集する</title>
</head>
<body>

<h1>ユーザー情報変更</h1>

<form action="" method="post" enctype="multipart/form-data" >
<p>ニックネーム</p>
 <input  class="form" type="text" name="name" value="<?php print(htmlspecialchars($user['name'],ENT_QUOTES));?>">
 <?php if($error['name']==='blank'):?>
  <p class="error">＊ニックネームを入力して下さい</p>
 <?php endif;?>


<p>メールアドレス</p>
 <input class="form" type="text" name="email" value="<?php print(htmlspecialchars($user['email'],ENT_QUOTES));?>">

  <?php if($error['email']==='blank'):?>
   <p class="error">＊メールアドレスを入力して下さい</p>
  <?php endif;?>
  
 


<p>お住まいの地域</p>
<select name="city">
<option value="" selected><?php print(htmlspecialchars($user['city'],ENT_QUOTES));?></option>
<option value="北海道">北海道</option>
<option value="青森県">青森県</option>
<option value="岩手県">岩手県</option>
<option value="宮城県">宮城県</option>
<option value="秋田県">秋田県</option>
<option value="山形県">山形県</option>
<option value="福島県">福島県</option>
<option value="茨城県">茨城県</option>
<option value="栃木県">栃木県</option>
<option value="群馬県">群馬県</option>
<option value="埼玉県">埼玉県</option>
<option value="千葉県">千葉県</option>
<option value="東京都">東京都</option>
<option value="神奈川県">神奈川県</option>
<option value="新潟県">新潟県</option>
<option value="富山県">富山県</option>
<option value="石川県">石川県</option>
<option value="福井県">福井県</option>
<option value="山梨県">山梨県</option>
<option value="長野県">長野県</option>
<option value="岐阜県">岐阜県</option>
<option value="静岡県">静岡県</option>
<option value="愛知県">愛知県</option>
<option value="三重県">三重県</option>
<option value="滋賀県">滋賀県</option>
<option value="京都府">京都府</option>
<option value="大阪府">大阪府</option>
<option value="兵庫県">兵庫県</option>
<option value="奈良県">奈良県</option>
<option value="和歌山県">和歌山県</option>
<option value="鳥取県">鳥取県</option>
<option value="島根県">島根県</option>
<option value="岡山県">岡山県</option>
<option value="広島県">広島県</option>
<option value="山口県">山口県</option>
<option value="徳島県">徳島県</option>
<option value="香川県">香川県</option>
<option value="愛媛県">愛媛県</option>
<option value="高知県">高知県</option>
<option value="福岡県">福岡県</option>
<option value="佐賀県">佐賀県</option>
<option value="長崎県">長崎県</option>
<option value="熊本県">熊本県</option>
<option value="大分県">大分県</option>
<option value="宮崎県">宮崎県</option>
<option value="鹿児島県">鹿児島県</option>
<option value="沖縄県">沖縄県</option>
</select>




<p>プロフィール写真(任意)</p>

<img id="user-picture" src="user_picture/<?php print(htmlspecialchars($user['picture'],ENT_QUOTES));?>" alt="ユーザー画像">

 <input type="file" name="new-image">

 <?php if($error['image'] === 'type'):?>
 <p class="error">＊画像ファイル形式はjpg、gif、pngを選択して下さい</p>
 <?php endif;?>

 

 <div class="link-buton">
<input class="submit-buton" type="submit" name="update-check" value="編集内容を確認する">

<a class="login-link" href="user_page.php?id=<?php print(htmlspecialchars($user['id'],ENT_QUOTES));?>">ユーザーページに戻る</a>
</div>
</form>
 
</body>
</html>