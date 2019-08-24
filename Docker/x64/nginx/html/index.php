<?php
session_start();
if (!isset($_SESSION["user"])) {
    header('Location: /login.php');
    exit;
}
include($_SERVER['DOCUMENT_ROOT'] . '/menu_load.php');
include($_SERVER['DOCUMENT_ROOT'] . '/db_setting.php');

try {
    $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4', $DB_USER, $DB_PASS);
    $sql = $pdo->prepare("SELECT * FROM login WHERE username=?");
    $sql->bindValue(1, $_SESSION["user"]);
    $sql->execute();
    $user = $sql->fetchAll();
} catch (Exception $e) {
    $errorMessages[] = "データベースエラーです";
    $_SESSION["errorMessages"]=$errorMessages;
    header('Location: /operate_error.php');
    exit;
}

function permission($username)
{
    $permissionlist = "許可された権限:";
    if ($username[0]['addcard']==1) {
        $permissionlist .= " カード登録 /";
        $count = 1;
    }
    if ($username[0]['editcard']==1) {
        $permissionlist .= " カード編集・削除 /";
        $count = 1;
    }
    if ($username[0]['sendnotice']==1) {
        $permissionlist .= " 入退室通知手動送信 /";
        $count = 1;
    }
    if ($username[0]['viewexit']==1) {
        $permissionlist .= " 入退室履歴の閲覧 /";
        $count = 1;
    }
    if ($username[0]['shutdown']==1) {
        $permissionlist .= " システム操作 /";
        $count = 1;
    }
    if ($username[0]['edituser']==1) {
        $permissionlist .= " 管理ユーザーの追加・編集・削除 /";
        $count = 1;
    }
    if ($count==1) {
        $permissionlist = substr($permissionlist, 0, -1);
    //0から-1を切り出し
    } else {
        $permissionlist = "許可された権限: なし";
    }

    return $permissionlist;
}
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
    <div class="page-content">
      <!-- Your content goes here -->
    </div>
    <div class="c-card-padding">
      <div class="c-large-card mdl-card mdl-shadow--4dp">
        <div class="mdl-card__supporting-text">
          トップページ
        </div>
        <div class="mdl-card__supporting-text">
          <?php echo(permission($user)); ?>
        </div>
      </div>
    </div>
  </main>
</body>

</html>
