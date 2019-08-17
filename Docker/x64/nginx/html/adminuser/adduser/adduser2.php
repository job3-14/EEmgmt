<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}


include($_SERVER['DOCUMENT_ROOT'] . '/db_setting.php');
$errorMessages = array();
$permission = array();
$permission2 = array();

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

if($errorMessages){
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: /normal_error.php');
}else{
$_SESSION["adduser"] = $_POST["user"];
$_SESSION["addpassword"] = password_hash($_POST["password1"], PASSWORD_DEFAULT);

if(isset($_POST["addcard"])){
  $permission[] = "カード登録";
  $_SESSION["permission"]["addcard"]=1;
}else{
  $_SESSION["permission"]["addcard"]=0;
}
if(isset($_POST["editcard"])){
  $permission[] = "カード編集・削除";
  $_SESSION["permission"]["editcard"]=1;
}else{
  $_SESSION["permission"]["editcard"]=0;
}
if(isset($_POST["sendnotice"])){
  $permission[] = "入退室通知手動送信";
  $_SESSION["permission"]["sendnotice"]=1;
}else{
  $_SESSION["permission"]["sendnotice"]=0;
}
if(isset($_POST["viewexit"])){
  $permission[] = "入退室履歴の閲覧";
  $_SESSION["permission"]["viewexit"]=1;
}else{
  $_SESSION["permission"]["viewexit"]=0;
}
if(isset($_POST["viewloginlog"])){
  $permission2[] = "管理者ログイン試行ログ閲覧";
  $_SESSION["permission"]["viewloginlog"]=1;
}else{
  $_SESSION["permission"]["viewloginlog"]=0;
}
if(isset($_POST["deletelog"])){
  $permission2[] = "入退室履歴の削除";
  $_SESSION["permission"]["deletelog"]=1;
}else{
  $_SESSION["permission"]["deletelog"]=0;
}
if(isset($_POST["initialize"])){
  $permission2[] = "初期化操作";
  $_SESSION["permission"]["initialize"]=1;
}else{
  $_SESSION["permission"]["initialize"]=0;
}
if(isset($_POST["setmail"])){
  $permission2[] = "メールサーバー設定操作";
  $_SESSION["permission"]["setmail"]=1;
}else{
  $_SESSION["permission"]["setmail"]=0;
}
if(isset($_POST["shutdown"])){
  $permission2[] = "システム終了(シャットダウン)";
  $_SESSION["permission"]["shutdown"]=1;
}else{
  $_SESSION["permission"]["shutdown"]=0;
}
if(isset($_POST["edituser"])){
  $permission3[] = "管理ユーザーの追加・編集・削除";
  $_SESSION["permission"]["edituser"]=1;
}else{
  $_SESSION["permission"]["edituser"]=0;
}
}
$_SESSION["adduser_status"] = 1;
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
    登録内容を確認してください
  </div>
  <div class="mdl-card__supporting-text">
    <h5>ユーザー名</h5>
    <?php echo $_POST["user"]; ?>
    <br>
    <h5>基本権限設定</h5>
    <?php  //エラーメッセージ
    if(!empty($permission)==0){
      echo("なし");
    }else{
    foreach($permission as $message){
      echo $message."<br>";
    }
    }
    ?>

    <h5>重要権限設定</h5>
    <?php  //エラーメッセージ
    if(!empty($permission2)==0){
      echo("なし");
    }else{
    foreach($permission2 as $message){
      echo $message."<br>";
    }
    }
    ?>

    <h5>最重要権限設定</h5>
    <div class="c-red">
    <?php
    if(!empty($permission3)==0){
      echo("なし");
    }else{
    echo("!!!この権限を有効にすると間接的に全ての権限を得ることができます!!! <br>");
    foreach($permission3 as $message){
      echo $message."<br>";
    }
    }
    ?>
  </div>


  <br>
  <div class="c-r-button">
  <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="button" onclick="history.back()">
     戻る
  </button>


  <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" type="button"  onclick="location.href='./adduser3.php'">
     登録実行
  </button>
</div>
</div>
</div>

</div>
      </main>
    </div>

  </body>
</html>
