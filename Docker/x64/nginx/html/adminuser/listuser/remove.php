<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}
$_SESSION["errorMessages"]= array();
include($_SERVER['DOCUMENT_ROOT'] . '/db_setting.php');
include($_SERVER['DOCUMENT_ROOT'] . '/menu_load.php');
include($_SERVER['DOCUMENT_ROOT'] . '/permission.php');
//権限確認
permission("edituser");
$username = $_GET["username"];

try {
    $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
    $sql  = $pdo->prepare("SELECT EXISTS(SELECT username FROM login WHERE username=?)");
    $sql->bindValue(1,$username);
    $sql->execute();
    $result=  $sql->fetchColumn();
}catch (Exception $e){
  $operateErrorMessages[] = "データベース接続エラーです";
}

try {
    $sql  = $pdo->prepare("SELECT username FROM login WHERE username=?");
    $sql->bindValue(1,$username);
    $sql->execute();
    $user = $sql->fetchAll();
}catch (Exception $e){
  $operateErrorMessages[] = "データベース接続エラーです";
}

if($result==0){
  $operateErrorMessages[] = "ユーザーが存在しません";
}

if(isset($operateErrorMessages)){
  $_SESSION["errorMessages"]=$operateErrorMessages;
  header('Location: /operate_error.php');
}

function noticeRadio($sql,$method){
  if($sql==$method){
    echo "checked";
  }
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
                <h5>ユーザー名: <?php echo $user[0]["username"];?> </h5>
                <p>このユーザーを削除します</p>
                <form action="./remove2.php" method="POST">
                  <input type="hidden" name="username" value="<?php echo $username; ?>">
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"  type="submit">
                    ユーザー削除実行
                  </button>
                </form>
                <br><br>
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="button" onclick="location.href='./userpage.php?username=<?php echo $username; ?>'">
                    キャンセル
                  </button>

               </div>
            </div>
          </div>
      </main>
      </div>
  </body>
  </html>
