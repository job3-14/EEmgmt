<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
exit;
}
include($_SERVER['DOCUMENT_ROOT'] . '/permission.php');
//権限確認
permission_redirect("addcard");
$idm = $_GET["idm"];
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
    新規登録する利用ユーザーの情報を入力してください。
  </div>
  <div class="mdl-card__supporting-text">

<form action="./adduser2.php" method="POST">

  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="text"  name="user">
    <label class="mdl-textfield__label">ユーザー名</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="text"  name="email">
    <label class="mdl-textfield__label">メールアドレス</label>
  </div>
  <br>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="text"  name="cardidm" value="<?php echo $idm;?>">
    <label class="mdl-textfield__label">ICカードIDm</label>
  </div>
  <br>
  <p>入退室通知送信先を選択してください</p>
  <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-1">
  <input type="radio" id="option-1" class="mdl-radio__button" name="sendMethod" value="email" checked>
  <span class="mdl-radio__label">Eメール</span>
  </label>
  <br>
  <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-2">
  <input type="radio" id="option-2" class="mdl-radio__button" name="sendMethod" value="line">
  <span class="mdl-radio__label">Line</span>
  </label>
  <br>
  <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-3">
  <input type="radio" id="option-3" class="mdl-radio__button" name="sendMethod" value="slack">
  <span class="mdl-radio__label">Slack</span>
  </label>
  <br>
  <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-4">
  <input type="radio" id="option-4" class="mdl-radio__button" name="sendMethod" value="none">
  <span class="mdl-radio__label">なし</span>
  </label>
  <br><br>
  <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" value=1>
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
