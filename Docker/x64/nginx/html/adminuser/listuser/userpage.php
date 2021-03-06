<?php
session_start();
if (!isset($_SESSION["user"])) {
    header('Location: /login.php');
    exit;
}
include($_SERVER['DOCUMENT_ROOT'] . '/db_setting.php');
include($_SERVER['DOCUMENT_ROOT'] . '/menu_load.php');
include($_SERVER['DOCUMENT_ROOT'] . '/permission.php');
//権限確認
permission_redirect("edituser");
$username = $_GET["username"];

try {
    $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4', $DB_USER, $DB_PASS);
    $sql  = $pdo->prepare("SELECT EXISTS(SELECT username FROM login WHERE username = ?)");
    $sql->bindValue(1, $username);
    $sql->execute();
    $result=  $sql->fetchColumn();
} catch (Exception $e) {
    $operateErrorMessages[] = "データベース接続エラーです";
}

try {
    $sql  = $pdo->prepare("SELECT * FROM login WHERE username = ?");
    $sql->bindValue(1, $username);
    $sql->execute();
    $user = $sql->fetchAll();
} catch (Exception $e) {
    $operateErrorMessages[] = "データベース接続エラーです";
}

if ($result==0) {
    $operateErrorMessages[] = "ユーザーが存在しません";
}

if (isset($operateErrorMessages)) {
    $_SESSION["errorMessages"]=$operateErrorMessages;
    header('Location: /operate_error.php');
    exit;
}

function permission($type)
{
    if ($type==1) {
        echo 'checked="checked"';
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
  <link rel="stylesheet" type="text/css" href="/custom.css">
</head>

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
            <h5>ユーザー名: <?php echo $username;?> </h5>
            <form action="./userpage2.php" method="POST">
              <input type="hidden" name="username" value="<?php echo $username; ?>">
              <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="button" onclick="location.href='./userpassword.php?username=<?php echo $username; ?>'">
                パスワード変更
              </button>
              <br>
              <h5>権限設定</h5>
              <p>許可する操作を選択してください</p>

              <div class="c-switch">
                <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-2">
                  <input type="checkbox" id="switch-2" class="mdl-switch__input" name="addcard" value=1 <?php permission($user[0]["addcard"]);?>>
                  <span class="mdl-switch__label">カード登録</span>
                </label>
              </div>

              <div class="c-switch">
                <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-3">
                  <input type="checkbox" id="switch-3" class="mdl-switch__input" name="editcard" value=1 <?php permission($user[0]["editcard"]);?>>
                  <span class="mdl-switch__label">カード編集・削除</span>
                </label>
              </div>

              <div class="c-switch">
                <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-4">
                  <input type="checkbox" id="switch-4" class="mdl-switch__input" name="sendnotice" value=1 <?php permission($user[0]["sendnotice"]);?>>
                  <span class="mdl-switch__label">入退室通知手動送信</span>
                </label>
              </div>

              <div class="c-switch">
                <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-5">
                  <input type="checkbox" id="switch-5" class="mdl-switch__input" name="viewexit" value=1 <?php permission($user[0]["viewexit"]);?>>
                  <span class="mdl-switch__label">入退室履歴の閲覧</span>
                </label>
              </div>

              <h5>重要権限設定</h5>
              <p>許可する操作を選択してください</p>

              <div class="c-switch">
                <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-10">
                  <input type="checkbox" id="switch-10" class="mdl-switch__input" name="shutdown" value=1 <?php permission($user[0]["shutdown"]);?>>
                  <span class="mdl-switch__label">システム終了(シャットダウン)</span>
                </label>
              </div>

              <h5>最重要権限設定</h5>
              <p>許可する操作を選択してください</p>
              <div class="c-switch">
                <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-11">
                  <input type="checkbox" id="switch-11" class="mdl-switch__input" name="edituser" value=1 <?php permission($user[0]["edituser"]);?>>
                  <span class="mdl-switch__label">管理ユーザーの追加・編集・削除</span>
                </label>
              </div>

              <p class="c-red">↑この権限を有効にすると間接的に全ての権限を得ることができます</p>

              <br>
              <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submit">
                更新
              </button>
              <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="button" onclick="location.href='./userpage.php?username=<?php echo $username; ?>'">
                リセット
              </button>
            </form>
            <br><br>
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="button" onclick="location.href='./remove.php?username=<?php echo $username; ?>'">
              このユーザーを削除
            </button>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>

</html>
