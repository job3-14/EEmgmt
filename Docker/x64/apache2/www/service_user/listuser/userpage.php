<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}
$_SESSION["errorMessages"]= array();
include($_SERVER['DOCUMENT_ROOT'] . '/db_setting.php');
include($_SERVER['DOCUMENT_ROOT'] . '/menu_load.php');
$name = $_GET["name"];

try {
    $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
    $sql  = $pdo->prepare("SELECT EXISTS(SELECT name FROM service_user WHERE name=?)");
    $sql->bindValue(1,$name);
    $sql->execute();
    $result=  $sql->fetchColumn();
}catch (Exception $e){
  $operateErrorMessages[] = "データベース接続エラーです";
}

try {
    $sql  = $pdo->prepare("SELECT * FROM login WHERE username=?");
    $sql->bindValue(1,$name);
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
      $menuName = "管理者管理ページ";
      menuload($menuName);
      ?>
      <main class="mdl-layout__content">
        <div class="page-content">
          <!-- Your content goes here -->
          <div class="c-card-padding">
            <div class="c-large-card mdl-card mdl-shadow--4dp">
              <div class="mdl-card__supporting-text"> 管理ユーザー情報 </div>
              <div class="mdl-card__supporting-text">
                <h5>ユーザー名: <?php echo $name;?> </h5>
                <form action="./userpage2.php" method="POST">
                  <br>
                  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text"  name="email">
                    <label class="mdl-textfield__label">メールアドレス(メイン)</label>
                  </div>
                  <br>
                  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text"  name="cardidm">
                    <label class="mdl-textfield__label">ICカードIDm</label>
                  </div>
                  <br>
                  <p>入退室通知送信先を選択してください</p>
                  <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-1">
                  <input type="radio" id="option-1" class="mdl-radio__button" name="sendMethod" value="email" checked>
                  <span class="mdl-radio__label">Eメール</span>
                  </label>
                  <br>
                  <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-2">
                  <input type="radio" id="option-2" class="mdl-radio__button" name="sendMethod" value="line">
                  <span class="mdl-radio__label">Line</span>
                  </label>
                  <br>
                  <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-3">
                  <input type="radio" id="option-3" class="mdl-radio__button" name="sendMethod" value="slack">
                  <span class="mdl-radio__label">Slack</span>
                  </label>
                  <br>
                  <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-4">
                  <input type="radio" id="option-4" class="mdl-radio__button" name="sendMethod" value="none">
                  <span class="mdl-radio__label">なし</span>
                  </label>
                  <br><br>
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submit">
                    更新
                  </button>
                  <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="button" onclick="location.href='./userpage.php?username=<?php echo $username; ?>'">
                      リセット
                    </button>
                </form>

               </div>
            </div>
          </div>
      </main>
      </div>
  </body>
  </html>
