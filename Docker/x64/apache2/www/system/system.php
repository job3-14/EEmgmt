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
      $menuName = "システム利用者管理メニュー";
      menuload($menuName);
      ?>
      <main class="mdl-layout__content">
        <div class="page-content"><!-- Your content goes here -->


        <div class="c-card">
            <div class="mdl-card mdl-shadow--4dp">
            <div class="mdl-card__supporting-text">
              システム操作
            </div>
            <div class="mdl-card__supporting-text">
              <form action="./system2.php" method="POST">
              <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-1">
              <input type="radio" id="option-1" class="mdl-radio__button" name="sendMethod" value="shutdown" checked>
              <span class="mdl-radio__label">システム終了(シャットダウン)</span>
              </label>
              <br>
              <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-2">
              <input type="radio" id="option-2" class="mdl-radio__button" name="sendMethod" value="restart">
              <span class="mdl-radio__label">システム再起動(リブート)</span>
              </label>
              <br><br>
              <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-3">
              <input type="radio" id="option-3" class="mdl-radio__button" name="sendMethod" value="initialize">
              <span class="mdl-radio__label">初期化</span>
              </label>
              <br><br>
              <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                    確認
                </button>
              </form>
            </div>
          </div>
          </div>


        </div>
      </main>
    </div>

  </body>
</html>
