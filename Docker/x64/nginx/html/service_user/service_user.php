<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}
include($_SERVER['DOCUMENT_ROOT'] . '/menu_load.php');
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
    <!-- The drawer is always open in large screens. The header is always shown,
      even in small screens. -->
      <?php
      $menuName = "利用者管理メニュー";
      menuload($menuName);
      ?>
      <main class="mdl-layout__content">
        <div class="page-content"><!-- Your content goes here -->




          <div class="c-card-padding">
            <div class="c-card mdl-card mdl-shadow--4dp">
              <div class="mdl-card__supporting-text">
                利用ユーザー設定
              </div>
              <div class="mdl-card__supporting-text">
                <a href="./adduser/adduser.php">利用ユーザー情報の登録</a><br>
                <a href="./listuser/list.php">利用ユーザー情報の一覧</a><br>
              </div>
            </div>
          </div>



</div>
      </main>
    </div>

  </body>
</html>
