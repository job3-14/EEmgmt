<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}
$_SESSION["errorMessages"]= array();
include($_SERVER['DOCUMENT_ROOT'] . '/db_setting.php');
include($_SERVER['DOCUMENT_ROOT'] . '/menu_load.php');
$username = $_GET["username"];

?>
  <!DOCTYPE html>
  <html>
  <head>
    <title>入退室管理システム</title>
    <link rel="stylesheet" href="/material/material.min.css">
    <script src="/material/material.min.js"></script>
    <link rel="stylesheet" href="/material/iconfont/material-icons.css">
    <link rel="stylesheet" type="text/css" href="/custom.css"> </head>
  <body>
    <!-- The drawer is always open in large screens. The header is always shown,
      even in small screens. -->
    <?php
      $menuName = "管理者管理ページ";
      menuload($menuName);
      ?>
      <main class="mdl-layout__content">
        <div class="page-content">
          <!-- Your content goes here -->
          <div class="c-card-padding">
            <div class="c-large-card mdl-card mdl-shadow--4dp">
              <div class="mdl-card__supporting-text"> パスワードを変更します </div>
              <div class="mdl-card__supporting-text">
                <h5>ユーザー名: <?php echo $username;?> </h5>
                <form action="./userpassword2.php" method="POST">
                  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="password"  name="password1">
                    <label class="mdl-textfield__label">新しいパスワードを入力</label>
                  </div>
                <br>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="password"  name="password2">
                    <label class="mdl-textfield__label">パスワードを再度入力</label>
                  </div>
                  <br>
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submit">
                    更新
                  </button>
                </form>

               </div>
            </div>
          </div>
      </main>
      </div>
  </body>
  </html>
