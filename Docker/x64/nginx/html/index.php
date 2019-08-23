<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
exit;
}
include($_SERVER['DOCUMENT_ROOT'] . '/menu_load.php');
?>


<!DOCTYPE html>
<html>
  <head>
    <title>入退室管理システム</title>
    <link rel="stylesheet" href="./material/material.min.css">
    <script src="./material/material.min.js"></script>
    <link rel="stylesheet" href="./material/iconfont/material-icons.css">
    <link rel="stylesheet" type="text/css" href="custom.css">
  </head>
  <body>
    <!-- The drawer is always open in large screens. The header is always shown,
      even in small screens. -->
      <?php
      $menuName = "管理トップメニュー";
      menuload($menuName);
      ?>
      <main class="mdl-layout__content">
        <div class="page-content"><!-- Your content goes here --></div>
        <div class="c-card-padding">
          <div class="c-large-card mdl-card mdl-shadow--4dp">
            <div class="mdl-card__supporting-text">
            許可された権限
          </div>
          <div class="mdl-card__supporting-text">
            <p>helloworld</p>
        </div>
        </div>

</div>
      </main>
    </div>

  </body>
</html>
