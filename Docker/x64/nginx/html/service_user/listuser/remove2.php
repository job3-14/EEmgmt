<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}
include($_SERVER['DOCUMENT_ROOT'] . '/db_setting.php');
$idm = $_POST["idm"];

try {
    $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
    $sql  = $pdo->prepare("SELECT EXISTS(SELECT name FROM service_user WHERE idm=?)");
    $sql->bindValue(1,$idm);
    $sql->execute();
    $result=  $sql->fetchColumn();
}catch (Exception $e){
  $operateErrorMessages[] = "データベース接続エラーです";
}

try {
    $sql  = $pdo->prepare("DELETE FROM service_user WHERE idm=?");
    $sql->bindValue(1,$idm);
    $sql->execute();
}catch (Exception $e){
  $operateErrorMessages[] = "データベース接続エラーです";
}

if($result==0){
  $operateErrorMessages[] = "ユーザーが存在しません";
}

if(isset($operateErrorMessages)){
  $_SESSION["errorMessages"]=$operateErrorMessages;
  header('Location: /operate_error.php');
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
          <span class="mdl-layout-title">利用ユーザー更新ページ</span>
          <!-- Add spacer, to align navigation to the right -->
          <div class="mdl-layout-spacer"></div>
          <!-- Navigation. We hide it in small screens. -->
          <nav class="mdl-navigation mdl-layout--large-screen-only">
          </nav>
        </div>
      </header>
      <main class="mdl-layout__content">
        <div class="page-content"><!-- Your content goes here -->


<div class="c-add-card mdl-card mdl-shadow--4dp">
  <div class="mdl-card__supporting-text">
    完了
  </div>
  <div class="mdl-card__supporting-text">
    削除が完了しました

  <br>
  <div class="c-r-button">
  <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" type="button" onclick="location.href='./list.php'">
     ユーザー一覧へ戻る
  </button>
</div>
</div>
</div>

</div>
      </main>
    </div>

  </body>
</html>
