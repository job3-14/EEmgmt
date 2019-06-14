<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}

$_SESSION["errorMessages"]= array();
include($_SERVER['DOCUMENT_ROOT'] . '/db_setting.php');
try {
    $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
    $sql  = $pdo->prepare("SELECT * FROM login ORDER BY addcard LIMIT 0,100");
    $sql->execute();
    $userlist=  $sql->fetchAll();
    $sql  = $pdo->prepare("SELECT COUNT(username) FROM login");
    $sql->execute();
    $counts = $sql->fetchColumn();
}catch (Exception $e){
  $errorMessages[] = "データベースエラーです";
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: /operate_error.php');
}

function permission($username) {
  $permissionlist = "許可された権限:";
  if ($username['addcard']==1){
    $permissionlist .= " カード登録 /";
    $count = 1;
  }
  if ($username['editcard']==1){
    $permissionlist .= " カード編集・削除 /";
    $count = 1;
  }
  if ($username['sendnotice']==1){
    $permissionlist .= " 入退室通知手動送信 /";
    $count = 1;
  }
  if ($username['viewexit']==1){
    $permissionlist .= " 入退室履歴の閲覧 /";
    $count = 1;
  }
  if ($username['viewloginlog']==1){
    $permissionlist .= " 管理者ログイン試行ログ閲覧 /";
    $count = 1;
  }
  if ($username['deletelog']==1){
    $permissionlist .= " 入退室履歴の削除 /";
    $count = 1;
  }
  if ($username['initialize']==1){
    $permissionlist .= " 初期化操作 /";
    $count = 1;
  }
  if ($username['setmail']==1){
    $permissionlist .= " メールサーバー設定操作 /";
    $count = 1;
  }
  if ($username['shutdown']==1){
    $permissionlist .= " システム操作 /";
    $count = 1;
  }
  if ($username['edituser']==1){
    $permissionlist .= " 管理ユーザーの追加・編集・削除 /";
    $count = 1;
  }
  if ($count==1){
    $permissionlist = substr($permissionlist, 0 ,-1);
    //0から-1を切り出し
  }else{
    $permissionlist = "許可された権限: なし";
  }

  return $permissionlist;
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
    <!-- The drawer is always open in large screens. The header is always shown,
      even in small screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer
                mdl-layout--fixed-header">
      <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
          <div class="head-title">
            <span class="mdl-layout-title">管理ユーザー</span>
          </div>
          <div class="mdl-layout-spacer"></div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable
                      mdl-textfield--floating-label mdl-textfield--align-right">
          <div class="logout">
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" onclick="location.href='/logout.php'">
             ログアウト
            </button>
          </div>
          </div>
        </div>
      </header>
      <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">入退室管理システム</span>
        <nav class="mdl-navigation">
          <a class="mdl-navigation__link" href="">管理トップ</a>
          <a class="mdl-navigation__link" href="">入退室履歴</a>
          <a class="mdl-navigation__link" href="">新規登録</a>
          <a class="mdl-navigation__link" href="">登録情報変更</a>
          <a class="mdl-navigation__link" href="">管理ユーザー</a>
          <a class="mdl-navigation__link" href="">システム操作</a>
        </nav>
      </div>
      <main class="mdl-layout__content">
        <div class="page-content"><!-- Your content goes here -->
          <div class="c-card mdl-card mdl-shadow--4dp">
            <div class="mdl-card__supporting-text">
              ユーザー情報一覧
            </div>
            <div class="mdl-card__supporting-text">
              <p>１ページにつき100件表示します</p>
              <p>ユーザー件数: <?php echo $counts;?></p>
              <ul class='mdl-list'>
              <?php
              foreach($userlist as $username){
                echo '<li class="mdl-list__item mdl-list__item--three-line">';
                echo '<span class="mdl-list__item-primary-content">';
                echo '<i class="material-icons mdl-list__item-avatar">person</i>';
                echo '<span>'.$username['username'].'</span>';
                echo '<span class="mdl-list__item-text-body">'.permission($username).'</span>';
                echo '</span>';
                echo '</li>';
              }
               ?>
              </ul>

          </div>
          </div>



</div>
      </main>
    </div>

  </body>
</html>
