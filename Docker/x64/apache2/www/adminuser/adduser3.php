<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}
if ($_SESSION["adduser_status"] !== 1){
header('Location: ./adduser.php');
}
unset($_SESSION["adduser_status"]);

require_once('../db_setting.php');
$errorMessages = array();

try {
  $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
}catch (Exception $e){
  $errorMessages[] = "データベースエラーです";
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: ./adduser_error.php');
}

try {
  if(!$_SESSION["adduser"]==""){
    $sql  = $pdo->prepare("SELECT EXISTS(SELECT username FROM login WHERE username = ?)");
    $sql->bindValue(1,$_SESSION["adduser"]);
    $sql->execute();
    $result=  $sql->fetchColumn();
    $dberror=0;
  }
}catch (Exception $e){
  $dberror=1;
}

if (isset($_SESSION["adduser"])){
  if($_SESSION["adduser"]=="" || $result==1 || $dberror==1){
    $errorMessages[] = "操作エラーです。1";
    $_SESSION["errorMessages"]=$errorMessages;
    header('Location: ./adduser_error.php');
  }

  echo "正常";




}else{
  $errorMessages[] = "操作エラーです。2";
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: ./adduser_error.php');
}


unset($_SESSION["permission"]);
unset($_SESSION["permission2"]);
?>


<!DOCTYPE html>
<html>
  <head>
    <title>入退室管理システム</title>
    <link rel="stylesheet" href="/material/material.min.css">
    <script src="/material/material.min.js"></script>
    <link rel="stylesheet" href="/material/iconfont/material-icons.css">
    <link rel="stylesheet" type="text/css" href="/custom.css">
  </head>
  <body>

    <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
          <!-- Title -->
          <span class="mdl-layout-title">管理ユーザー新規登録ウィザード</span>
          <!-- Add spacer, to align navigation to the right -->
          <div class="mdl-layout-spacer"></div>
          <!-- Navigation. We hide it in small screens. -->
          <nav class="mdl-navigation mdl-layout--large-screen-only">
          </nav>
          <div class="logout">
          <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" onclick="location.href='/adminuser/adminuser.php'">
             キャンセル
          </button>
          </div>
        </div>
      </header>
      <main class="mdl-layout__content">
        <div class="page-content"><!-- Your content goes here -->


<div class="c-add-card mdl-card mdl-shadow--4dp">
  <div class="mdl-card__supporting-text">
    完了
  </div>
  <div class="mdl-card__supporting-text">
    登録が完了しました

  <br>
  <div class="c-r-button">
  <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" type="button" >
     メニューへ戻る
  </button>
</div>
</div>
</div>

</div>
      </main>
    </div>

  </body>
</html>
