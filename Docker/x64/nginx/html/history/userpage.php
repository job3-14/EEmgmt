<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
exit;
}
include($_SERVER['DOCUMENT_ROOT'] . '/db_setting.php');
include($_SERVER['DOCUMENT_ROOT'] . '/menu_load.php');
include($_SERVER['DOCUMENT_ROOT'] . '/permission.php');
//権限確認
permission_redirect("viewexit");
$idm = $_GET["idm"];

try {
    $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
    $sql  = $pdo->prepare("SELECT EXISTS(SELECT name FROM service_user WHERE idm=?)");
    $sql->bindValue(1,$idm);
    $sql->execute();
    $result=  $sql->fetchColumn();
}catch (Exception $e){
  $operateErrorMessages[] = "データベース接続エラーです";
}

try {
    $sql  = $pdo->prepare("SELECT name FROM service_user WHERE idm=?");
    $sql->bindValue(1,$idm);
    $sql->execute();
    $user = $sql->fetchAll();
}catch (Exception $e){
  $operateErrorMessages[] = "データベース接続エラーです";
}

try {
    $sql = $pdo->prepare("SELECT * FROM history WHERE idm=? ORDER BY date DESC");
    $sql->bindValue(1,$idm);
    $sql->execute();
    $userList = $sql->fetchAll();
}catch (Exception $e){
  $operateErrorMessages[] = "データベース接続エラーです";
}

if($result==0){
  $operateErrorMessages[] = "ユーザーが存在しません";
}

if(isset($operateErrorMessages)){
  $_SESSION["errorMessages"]=$operateErrorMessages;
  header('Location: /operate_error.php');
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
    <link rel="stylesheet" type="text/css" href="/custom.css"> </head>
  <body>
    <!-- The drawer is always open in large screens. The header is always shown,
      even in small screens. -->
    <?php
      $menuName = "利用者者管理ページ";
      menuload($menuName);
      ?>
      <main class="mdl-layout__content">
        <div class="page-content">
          <!-- Your content goes here -->
          <div class="c-card-padding">
            <div class="c-large-card mdl-card mdl-shadow--4dp">
              <div class="mdl-card__supporting-text"> 管理ユーザー情報 </div>
              <div class="mdl-card__supporting-text">
                <h5>ユーザー名: <?php echo $user[0]["name"];?> </h5>
                <table class="mdl-data-table mdl-js-data-table">
<thead>
  <tr>
    <th class="mdl-data-table__cell--non-numeric">種別</th>
    <th class="mdl-data-table__cell--non-numeric">日時</th>
  </tr>
</thead>
<tbody>
  <?php
  foreach($userList as $userInfo){
    echo '<tr>';
    echo '<td class="mdl-data-table__cell--non-numeric">'.$userInfo["type"].'</td>';
    echo '<td class="mdl-data-table__cell--non-numeric">'.$userInfo["date"].'</td>';
    echo '</tr>';
  }
  ?>
  </tbody>
</table>
               </div>
            </div>
          </div>
      </main>
      </div>
  </body>
  </html>
