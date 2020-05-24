<?php
  try{
    $db = new PDO('mysql:dbname=Thanks;
                   host=localhost;
                   port=8889;charset=utf8','root','root',
                  array(
                      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                      PDO::ATTR_EMULATE_PREPARES => false,
                  ));
  }

  catch(PDOException $e){
    print('DB接続エラー:' . $e->getMessage());
  }

