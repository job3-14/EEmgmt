<?php
session_start();

require_once('db_setting.php');
//エラーメッセージの定義
$errorMessage = "";

if (isset($_POST["user"])){
 if ($_POST["user"]=="" || $_POST["password"]==""){
   if($_POST["user"]==""){
     $errorMessage =  "ユーザー名を入力してください";
     echo $errorMessage;
   }
   if ($_POST["password"]==""){
     $errorMessage = "パスワードを入力してください";
     echo $errorMessage;
   }
}else{
  $user = $_POST["user"];
  $password = $_POST["password"];
  //データベース接続
  $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
     $sql  = $pdo->prepare("SELECT password  FROM user WHERE name= ?");
     $sql->bindValue(1,$user);
     $sql->execute();
  $password_hash =  $sql->fetchColumn();
  //データベース終了
  echo $password_hash."<br>";


if (password_verify($password, $password_hash)) {
    echo "認証成功";
    $_SESSION["user"] = $user;
} else {
    echo "ユーザー名またはパスワードが間違っています";
}
}
}
?>



<!DOCTYPE html>
<html>
  <head>
    <title>ログイン</title>
    <link rel="stylesheet" href="./material/material.min.css">
    <script src="./material/material.min.js"></script>
    <link rel="stylesheet" href="./material/iconfont/material-icons.css">
    <link rel="stylesheet" type="text/css" href="custom.css">
  </head>
  <body>
<div class="c-login-card">
<div class="demo-card-wide mdl-card mdl-shadow--2dp">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text">ログイン</h2>
  </div>
  <div class="mdl-card__supporting-text">
<p>入退室管理システムへログイン<p>


<form action="#" method="POST">
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="text"  name="user">
    <label class="mdl-textfield__label">ユーザー名</label>
  </div>


  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="password"  name="password">
    <label class="mdl-textfield__label">パスワード</label>
  </div>

<div class="c-login">
<button class="mdl-button mdl-js-button mdl-button--raised" type="submit">
  ログイン
</button>
</div>
</form>




  </div>
</div>
</div>

  </body>
</html>
