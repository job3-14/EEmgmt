<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}

$_POST = array();
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
    新規登録する管理ユーザーの情報を入力してください。
  </div>
  <div class="mdl-card__supporting-text">

<form action="./adduser-error.php" method="POST">
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="text"  name="user">
    <label class="mdl-textfield__label">ユーザー名</label>
  </div>
<br>
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="password"  name="password1">
    <label class="mdl-textfield__label">パスワード</label>
  </div>
<br>
<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="password"  name="password2">
    <label class="mdl-textfield__label">パスワードを再度入力</label>
  </div>
<br>
<h5>権限設定</h5>
<p>許可する操作を選択してください</p>

<div class="c-switch">
<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-2">
  <input type="checkbox" id="switch-2" class="mdl-switch__input" name="permission[]" value="addcard">
  <span class="mdl-switch__label">カード登録</span>
</label>
</div>

<div class="c-switch">
<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-3">
  <input type="checkbox" id="switch-3" class="mdl-switch__input" name="permission[]" value="editcard">
  <span class="mdl-switch__label">カード編集・削除</span>
</label>
</div>

<div class="c-switch">
<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-4">
  <input type="checkbox" id="switch-4" class="mdl-switch__input" name="permission[]" value="sendnotice">
  <span class="mdl-switch__label">入退室通知手動送信</span>
</label>
</div>

<div class="c-switch">
<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-5">
  <input type="checkbox" id="switch-5" class="mdl-switch__input" name="permission[]" value="viewexit">
  <span class="mdl-switch__label">入退室履歴の閲覧</span>
</label>
</div>

<h5>重要権限設定</h5>
<p>許可する操作を選択してください</p>

<div class="c-switch">
<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-1">
  <input type="checkbox" id="switch-1" class="mdl-switch__input" name="importantPermission[]" value="edituser">
  <span class="mdl-switch__label">管理ユーザーの追加・編集・削除</span>
</label>
</div>

<div class="c-switch">
<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-6">
  <input type="checkbox" id="switch-6" class="mdl-switch__input" name="importantPermission[]" value="viewloginlog">
  <span class="mdl-switch__label">管理者ログイン試行ログ閲覧</span>
</label>
</div>

<div class="c-switch">
<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-8">
  <input type="checkbox" id="switch-8" class="mdl-switch__input" name="importantPermission[]" value="deletelog">
  <span class="mdl-switch__label">入退室履歴の削除</span>
</label>
</div>

<div class="c-switch">
<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-7">
  <input type="checkbox" id="switch-7" class="mdl-switch__input" name="importantPermission[]" value="Initialize">
  <span class="mdl-switch__label">初期化操作</span>
</label>
</div>

<div class="c-switch">
<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-7">
  <input type="checkbox" id="switch-7" class="mdl-switch__input" name="importantPermission[]" value="setmail">
  <span class="mdl-switch__label">メールサーバー設定操作</span>
</label>
</div>

<div class="c-switch">
<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-8">
  <input type="checkbox" id="switch-8" class="mdl-switch__input" name="importantPermission[]" value="shutdown">
  <span class="mdl-switch__label">システム終了(シャットダウン)</span>
</label>
</div>

<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="submit">
   入力内容確認
</button>
</form>






</div>
</div>






</div>
      </main>
    </div>



  </body>
</html>