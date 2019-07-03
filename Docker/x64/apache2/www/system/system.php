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

          <div class="c-card-padding">
            <div class="c-card mdl-card mdl-shadow--4dp">
            <div class="mdl-card__supporting-text">
              システム操作
            </div>
            <div class="mdl-card__supporting-text">
              <form action="./system2.php" method="POST">
              <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-1">
              <input type="radio" id="option-1" class="mdl-radio__button" name="operete" value="shutdown" checked>
              <span class="mdl-radio__label">システム終了(シャットダウン)</span>
              </label>
              <br>
              <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-2">
              <input type="radio" id="option-2" class="mdl-radio__button" name="operete" value="restart">
              <span class="mdl-radio__label">システム再起動(リブート)</span>
              </label>
              <br><br>
              <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-3">
              <input type="radio" id="option-3" class="mdl-radio__button" name="operete" value="initialize">
              <span class="mdl-radio__label">初期化</span>
              </label>
              <br><br>
              <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-2">
                <input type="checkbox" id="switch-2" class="mdl-switch__input">
                <span class="mdl-switch__label">内容を確認後チェックを入れてください</span>
              </label>
              <div class="c-r-button">
              <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                    確認
                </button>
              </div>
              </form>
            </div>
          </div>
        </div>



        </div>
      </main>
    </div>

  </body>
</html>
