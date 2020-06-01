<?php
require('dbconnect.php');
session_start();


if(isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()){
  $members = $db->prepare('SELECT * FROM users WHERE id=?');
  $members->execute(array($_SESSION['id']));
  $member = $members->fetch();

}else{
  header('Location: login.php');}

$counts = $db->query('SELECT COUNT(*) AS cnt FROM posts WHERE create_time >= CURDATE()');
$todayCount = $counts->fetch();

$counts2 = $db->query('SELECT COUNT(*) AS cnt FROM posts');
$allCount = $counts2->fetch();

$page = $_REQUEST['page'];
if($page == ''){
  $page = 1;
}
$page = max($page,1);

$count = $db->query('SELECT COUNT(*) AS cnt FROM posts');
$cnt = $count->fetch();
$maxPage = ceil($cnt['cnt']/5);
$page = min($page,$maxPage);

$start = ($page - 1) * 5;


/*投稿内容をdbより引っ張る為の処理 */
 $posts = $db->prepare('SELECT u.name,u.picture,p.* FROM users u,posts p WHERE u.id = p.user_id ORDER BY p.create_time DESC LIMIT ?,5');
 $posts->bindParam(1, $start, PDO::PARAM_INT);
 $posts->execute();
 
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="index.css">
  <title>投稿一覧</title>
</head>
<body>

  <header class="page-header">
   <h1 class="main-title">Thanks!!  〜ありがとうを共有しよう〜</h1>
    <nav class="navi">
      <li><a class="new-buton" href="new.php">新規登録</a></li>
      <li><a class="login-buton" href="login.php">ログイン</a></li>
      <li><a class="logout-buton" href="logout.php">ログアウト</a></li>
    </nav>
  </header>
    

  <form action="" method="post">
  
  <h2><?php print(htmlspecialchars($member['name'],ENT_QUOTES));?>さん、おかえりなさい！ログインありがとうございます！</h2>

  <a class="create-buton "href="create.php">ありがとうを投稿する！</a></li>

 <div class="counter">
   <h3 class="total-count">累計<?php print(htmlspecialchars($allCount['cnt'],ENT_QUOTES));?>Thanks!達成中!!</h3>

   <h4 class="today-count">本日、<?php print(htmlspecialchars($todayCount['cnt'],ENT_QUOTES));?>件のありがとう！が投稿されています！！</h4>
   </div>


 <section class="post">
  <?php foreach($posts as $post):?> 
  <?php $ext = substr($post['picture'],-3);?>
  <div class="post-usre_picture">
  <?php if($ext == 'jpg' || $ext == 'png' || $ext == 'gif' ):?>
   <img class="user_picture" src="user_picture/<?php print(htmlspecialchars($post['picture']))?>" alt="">
   <?php else:?>
   <img class="user_picture" src="user_picture/no_image_yoko.jpg" alt="">
<?php endif;?>
   <p class="message"><?php print(htmlspecialchars($post['message']))?></p>
   </div>

   <div class="etc">
   <a class="user_name" href="user_page.php?id=<?php print(htmlspecialchars($post['user_id']))?>"><?php print(htmlspecialchars($post['name']))?></a>
   <p class="time"><?php print(htmlspecialchars($post['create_time']))?></p>
   </div>

  <?php if($_SESSION['id'] == $post['user_id']):?>
   <a class="delete" href="delete.php?id=<?php print(htmlspecialchars($post['id'],ENT_QUOTES));?>">投稿を削除する</a>
   <br>
  <?php endif;?>

  <?php endforeach;?>
</section>

<section class="page-select"> 
 <?php if($page < $maxPage):?>
  <li><a class="back-page "href="index.php?page=<?php print($page + 1);?>">過去の投稿</a></li>
 <?php endif;?>

 <?php if($page > 1):?>
  <li><a class="next-page" href="index.php?page=<?php print($page - 1);?>">新しい投稿</a></li>
  <?php endif;?>
</section>
  </form>
</body>
</html>