<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}
$_POST = array();
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
    LINEへ登録する情報を入力してください
  </div>
  <div class="mdl-card__supporting-text">
    <p>メールアドレスは前ページで設定した内容です。このページでは変更できません。</p>
    <p>メールアドレスを変更するには[戻る]ボタンをクリックし前ページで設定してください。</p>
<form action="./adduser4_line.php" method="POST">
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="text"  name="email_check" value="<?php echo $_SESSION["addcard"]["email"] ?>" readonly="readonly">
    <label class="mdl-textfield__label">メールアドレス</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="text"  name="password">
    <label class="mdl-textfield__label">パスワード</label>
  </div>

  <br>
  <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="button" onclick="history.back()">
     戻る
  </button>

  <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" value=1>
     次へ
  </button>

</form>
</div>
</div>
</div>
      </main>
    </div>



  </body>
</html>
