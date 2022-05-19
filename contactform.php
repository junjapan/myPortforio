<?php
  session_start();
  $errmessage = array();

  if( isset($_POST['confirm']) && $_POST['confirm'] ){
      // セッションクリア
      $_SESSION = array();
      // 入力チェック
      if( !$_POST['fullname'] ) {
          $errmessage[] = "名前を入力してください";
      } else if( mb_strlen($_POST['fullname']) > 100 ){
          $errmessage[] = "名前は100文字以内にしてください";
      }
      $_SESSION['fullname'] = htmlspecialchars($_POST['fullname'], ENT_QUOTES);

      if( !$_POST['email'] ) {
          $errmessage[] = "Eメールを入力してください";
      } else if( mb_strlen($_POST['email']) > 200 ){
          $errmessage[] = "Eメールは200文字以内にしてください";
      } else if( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ){
          $errmessage[] = "メールアドレスが不正です";
      }
      $_SESSION['email']    = htmlspecialchars($_POST['email'], ENT_QUOTES);

      if( !$_POST['message'] ){
          $errmessage[] = "お問い合わせ内容を入力してください";
      } else if( mb_strlen($_POST['message']) > 500 ){
          $errmessage[] = "お問い合わせ内容は500文字以内にしてください";
      }
      $_SESSION['message'] = htmlspecialchars($_POST['message'], ENT_QUOTES);
      //トークン作成
      $token = bin2hex(random_bytes(32));
      $_SESSION["token"] = $token;
      $mode = 'confirm';
  } else if( isset($_POST['send']) && $_POST['send'] && $_SESSION ){
      //送信ボタンを押下
      if( !$_POST["token"] || !$_SESSION["token"] || !$_SESSION["email"] ){
        $errmessage[] = "不正な処理が行われました";
        $_SESSION = array();
        $mode = 'err';
      } else if( $_POST["token"] != $_SESSION["token"] ){
        $errmessage[] = "不正な処理が行われました";
        $_SESSION = array();
        $mode = 'err';
      } else {
        // 送信ボタンを押したとき
        $message  = "お問い合わせを受け付けました \r\n"
                  . "名前: " . $_SESSION['fullname'] . "\r\n"
                  . "email: " . $_SESSION['email'] . "\r\n"
                  . "お問い合わせ内容:\r\n"
                  . preg_replace("/\r\n|\r|\n/", "\r\n", $_SESSION['message']);
        if( !mail($_SESSION['email'],'お問い合わせありがとうございます',$message) ){
          $errmessage[] = "サーバー等々に問題あり送信に失敗。しばらくお待ち頂いた後に再実施お願いします。";
        }
        if( !mail('watanabejapan2trap@gmail.com','お問い合わせありがとうございます',$message) ){
          $errmessage[] = "サーバー等々に問題あり送信に失敗。しばらくお待ち頂いた後に再実施お願いします。";
        }
        $mode = 'send';
      }
  } else {
    $errmessage[] = "想定外エラー。お手数ですが必要に応じて再実施お願いします。";
    $mode = 'err';
  }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>お問い合わせフォーム</title>
</head>
<body>
  <!-- エラー画面 -->
  <?php
        if( $errmessage ){
          echo '<div style="color:red;">';
          echo implode('<br>', $errmessage );
          echo '</div><br>';
          if( $mode  == 'err' ){
            echo  '<button type="button" onclick="location.href=\'./\'">TOP画面へ</button>';
          } else {
            echo '<button type="button" onclick="history.back()">戻る</button>';
          }
          $_SESSION = array();
          $_POST = array();
            } else {
  ?>
      <?php if( $mode == 'confirm' ){ ?>
        <!-- 確認画面 -->
        <form action="./contactform.php" method="post">
          <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>">
          名前    <?php echo $_SESSION['fullname'] ?><br>
          Eメール <?php echo $_SESSION['email'] ?><br>
          お問い合わせ内容<br>
          <?php echo nl2br($_SESSION['message']) ?><br>
          <button type="button" onclick="history.back()">戻る</button>
          <input type="submit" name="send" value="送信" />
        </form>
      <?php } else if( $mode == 'send' ){ ?>
        <!-- 完了画面 -->
        送信しました。お問い合わせありがとうございました。<br>
        <button type="button" onclick="location.href='./'">TOP画面へ</button>
      <?php } ?>
  <?php } ?>
  <?php exit; ?>
</body>
</html>
