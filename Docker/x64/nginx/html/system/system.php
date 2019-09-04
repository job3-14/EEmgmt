<?php
session_start();
if (!isset($_SESSION["user"])) {
    header('Location: /login.php');
    exit;
}
include($_SERVER['DOCUMENT_ROOT'] . '/menu_load.php');
include($_SERVER['DOCUMENT_ROOT'] . '/permission.php');
//権限確認
permission_redirect("shutdown");
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
    <div class="page-content">
      <!-- Your content goes here -->

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
              <div class="c-switch">
                <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-1">
                  <input type="checkbox" id="switch-1" class="mdl-switch__input" name="check" value=1>
                  <span class="mdl-switch__label">内容を確認後チェックを入れてください</span>
                </label>
              </div>
              <div class="c-r-button">
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                  実行
                </button>
              </div>
              <div class="c-red">
                システム終了・再起動は実行をクリック後即実行されます
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

</body>

</html>
