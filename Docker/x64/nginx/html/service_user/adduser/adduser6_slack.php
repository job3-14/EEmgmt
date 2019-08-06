<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}

include($_SERVER['DOCUMENT_ROOT'] . '/db_setting.php');
$pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
try {
  if(!$_POST["user"]==""){
    $sql  = $pdo->prepare("SELECT EXISTS(SELECT idm FROM service_user WHERE idm = ?)");
    $sql->bindValue(1,$_SESSION["addcard"]["cardidm"]);
    $sql->execute();
    $result=  $sql->fetchColumn();
  }
}catch (Exception $e){
  $errorMessages[] = "データベースエラーです";
}

if($result==1){
  $errorMessages[] = "操作エラーです";
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: /operate_error.php');
}

try {
  $sql  = $pdo->prepare("INSERT INTO service_user (idm,name,mainEmail,notice,address1,address2,address3,address4,address5) VALUES (?,?,?,?,?,?,?,?,?)");
  $sql->bindValue(1,$_SESSION["addcard"]["cardidm"]);
  $sql->bindValue(2,$_SESSION["addcard"]["user"]);
  $sql->bindValue(3,$_SESSION["addcard"]["email"]);
  $sql->bindValue(4,$_SESSION["addcard"]["sendMethod"]);
  for($i=0,$i2=5;$i<=4;$i++,$i2++){
    if($_SESSION["addcard"]["slackList"][$i]){
      $sql->bindValue($i2,$_SESSION["addcard"]["slackList"][$i]);
    }else{
      $sql->bindValue($i2,null,PDO::PARAM_NULL);
    }
  }
  $sql->execute();
}catch (Exception $e){
  $errorMessages[] = "データベースエラーです";
}

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
          <span class="mdl-layout-title">利用ユーザー新規登録ウィザード</span>
          <!-- Add spacer, to align navigation to the right -->
          <div class="mdl-layout-spacer"></div>
          <!-- Navigation. We hide it in small screens. -->
          <nav class="mdl-navigation mdl-layout--large-screen-only">
          </nav>
          <div class="logout">
          <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" onclick="location.href='../service_user.php'">
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
  <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" type="button" onclick="location.href='/service_user/service_user.php'">
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
