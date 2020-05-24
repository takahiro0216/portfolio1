<?php
require('dbconnect.php');
session_start();

/*登録内容確認ボタンを押した時のエラーチェック */
if(!empty($_POST)){

if(empty($_POST['name'])){
  $error['name'] = 'blank';}
    
if(empty($_POST['email'])){
   $error[email] ='blank';}
      
if(empty($error)){
     $member = $db->prepare('SELECT COUNT(*) AS cnt FROM users WHERE email=?');
     $member->execute(array($_POST['email']));
     $record = $member->fetch();
     if($record['cnt'] > 0 ){
       $error['email'] = 'duplicate';
     }
    }
if(strlen($_POST['password']) <4 ){
   $error['password'] = 'length';}
        
if(empty($_POST['password'])){
   $error['password'] ='blank';}

   if(!empty($error)){
     $error['image'] ='error_back';
   }
  

$fileName = $_FILES['image']['name'];
if(!empty($fileName)){
  $ext = substr($fileName, -3);
  if($ext != 'jpg' && $ext != 'gif' && $ext != 'png'){
    $error['image'] = 'type';
  }
}





if(empty($error)){
   $image = date('YmdHis'). $_FILES['image']['name'];
   move_uploaded_file($_FILES['image']['tmp_name'],'user_picture/'. $image); 
   $_SESSION['join'] = $_POST;
   $_SESSION['join']['image'] = $image;
   header('Location: new_check.php');
   exit();}
            
 }

 if($_REQUEST['action'] == 'rewrite' && isset($_SESSION['join'])){
   $_POST = $_SESSION['join'];}
?>




<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="new.css">
  <title>新規登録</title>
</head>
<body>

<h1>新規登録</h1>

<form action="" method="post" enctype="multipart/form-data" >
<p>ニックネーム</p>
 <input  class="form" type="text" name="name" placeholder="ニックネームをご記入下さい" value="<?php print(htmlspecialchars($_POST['name'],ENT_QUOTES));?>">
 <?php if($error['name']==='blank'):?>
  <p class="error">＊ニックネームを入力して下さい</p>
 <?php endif;?>


<p>メールアドレス</p>
 <input class="form" type="text" name="email" placeholder="メールアドレスをご記入下さい" value="<?php print(htmlspecialchars($_POST['email'],ENT_QUOTES));?>">

  <?php if($error['email']==='blank'):?>
   <p class="error">＊メールアドレスを入力して下さい</p>
  <?php endif;?>
  
  <?php if($error['email'] === 'duplicate'):?>
  <p class="error">＊入力されたメールアドレスは既に登録されています</p>
  <?php endif;?>


<p>お住まいの地域</p>
<select name="city">
<option value="" selected>お住まいの地域を選択して下さい（任意）</option>
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


<p>パスワード</p>
<input class="form" type="password" name="password" placeholder="パスワードをご記入下さい"  value="<?php print(htmlspecialchars($_POST['password'],ENT_QUOTES));?>">
<?php if($error['password']==='blank'):?>
  <p class="error">＊パスワードを入力して下さい</p>
<?php endif;?>

<?php if($error['password']==='length'):?>
  <p class="error">＊パスワードは４文字以上で入力して下さい</p>
 <?php endif;?>


<p>プロフィール写真(任意)</p>
 <input type="file" name="image"><br>
 <?php if($error['image'] === 'type'):?>
 <p class="error">＊画像ファイル形式はjpg、gif、pngを選択して下さい</p>
 <?php endif;?>

 <?php if($error['image'] === 'error_back'):?>
 <p class="error">＊恐れ入りますが再度、画像の選択をお願い致します（登録したい方のみ）</p>
 <?php endif;?>

 <div class="link-buton">
<input class="submit-buton" type="submit" value="登録内容を確認する">

<a class="login-link" href="login.php">＊既に登録済みの方はログインへ！</a>
</div>
</form>
</body>
</html>