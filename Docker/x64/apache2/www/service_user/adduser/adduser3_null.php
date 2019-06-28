<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}

$_SESSION["errorMessages"]=array();
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
    入力内容を確認してください
  </div>
  <div class="mdl-card__supporting-text">
    <h5>ユーザー名</h5>
    <?php echo $_SESSION["addcard"]["user"] ?>

    <h5>ICカードidm</h5>
    <?php echo $_SESSION["addcard"]["cardidm"]; ?>

    <h5>入退室通知送信方法</h5>
    <?php echo $_SESSION["addcard"]["sendMethod2"]; ?>

    <h5>メールアドレス(メイン)</h5>
    <?php echo $_SESSION["addcard"]["email"] ?>

    <br>
    <div class="c-r-button">
    <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="button" onclick="history.back()">
       戻る
    </button>

    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" type="button"  onclick="location.href='./adduser4_null.php'">
       登録実行
    </button>
</div>
</div>
</div>
      </main>
    </div>



  </body>
</html>
