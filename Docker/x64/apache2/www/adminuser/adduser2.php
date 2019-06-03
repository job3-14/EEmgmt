<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}
require_once('../db_setting.php');
$errorMessages = array();
try {
  if(!$_POST["user"]==""){
    $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
    $sql  = $pdo->prepare("SELECT EXISTS(SELECT username FROM login WHERE username = ?)");
    $sql->bindValue(1,$_POST["user"]);
    $sql->execute();
    $result=  $sql->fetchColumn();
    $dberror=0;
  }
}catch (Exception $e){
  $dberror=1;
}

if (isset($_POST["user"])){
  if($_POST["user"]=="" || $_POST["password1"]=="" || $_POST["user"]==$_POST["password1"] || !preg_match("/^[a-zA-Z0-9]+$/", $_POST["user"]) || strlen($_POST["password1"])<6 || strlen($_POST["password1"])>=50 || $result==1 || $dberror==1){
    if($_POST["user"]==""){
      $errorMessages[] = "ユーザー名を入力してください";
    }
    if($_POST["user"]==$_POST["password1"] && !$_POST["user"]==""){
      $errorMessages[] ="ユーザーとパスワードは一致してはいけません。違う組み合わせにしてください";
    }
    if($_POST["password1"]==""){
      $errorMessages[] = "パスワードを入力してください";
    }elseif($_POST["password2"]==""){
      $errorMessages[] = "パスワードを2度入力してください";
    }elseif($_POST["password1"]!==$_POST["password2"]){
      $errorMessages[] = "パスワードが一致していません";
    }
    if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST["user"]) && !$_POST["user"]==""){
      $errorMessages[] = "ユーザー名は半角文字数字のみが使用できます";
    }
    if(strlen($_POST["password1"])<6 || strlen($_POST["password1"])>=50){
      $errorMessages[] = "パスワードは6文字から50文字で入力してください。";
    }
    if($result==1){
      $errorMessages[] = "このユーザー名は既に使用されている為使えません。別のユーザー名をご利用ください";
    }
    if($dberror==1){
      $errorMessages[] = "データベース確立エラー";
    }
    $_SESSION["errorMessages"]=$errorMessages;
    header('Location: ./adduser_error.php');
}
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
    以下のエラー内容を修正してください
  </div>
  <div class="mdl-card__supporting-text">
    <div class="c-errormessage">
    <?php  //エラーメッセージ
    foreach($errorMessages as $errorMessage){
    echo '<img src="/img/HighPriority.png" class="c-login-img">';
    echo $errorMessage."<br>";
    }
    ?>
    <br>
  </div>
  <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="button" onclick="history.back()">
     戻る
  </button>
</div>
</div>

</div>
      </main>
    </div>

  </body>
</html>
