<?php
session_start();
if (!isset($_SESSION["user"])) {
    header('Location: /login.php');
    exit;
}
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
        <span class="mdl-layout-title">入退室管理システム</span>
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
      <div class="page-content">
        <!-- Your content goes here -->


        <div class="c-add-card mdl-card mdl-shadow--4dp">
          <div class="mdl-card__supporting-text">
            以下のエラー内容を修正してください
          </div>
          <div class="mdl-card__supporting-text">
            <div class="c-errormessage">
              <?php  //エラーメッセージ
    foreach ($_SESSION["errorMessages"] as $errorMessage) {
        echo '<img src="/img/HighPriority.png" class="c-login-img">';
        echo $errorMessage."<br>";
        $_SESSION["errorMessages"]=array();
    }
    unset($_SESSION["errorMessages"]);
    ?>
              <br>
            </div>
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="button" onclick="history.back()">
              戻る
            </button>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>

</html>
