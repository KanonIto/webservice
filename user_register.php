<?php
  require_once('./functions.php');
  session_start();


  // POSTリクエストの場合
  if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 送られた値を変数に格納
    $username = $_POST['username'];
    $passwd = $_POST['passwd'];
    $group_id = $_POST['group_id'];
    $passwd_confirmation = $_POST['passwd_confirmation'];


    // 未入力の項目があるか
    if (empty($username) || empty($passwd) || empty($passwd_confirmation)|| empty($group_id)) {
        $_SESSION["error"] = "入力されていない項目があります";
        header("Location: user_register.php");
        return;
    }

    // パスワードとパスワード確認が一致しているか
    if ($passwd !== $passwd_confirmation) {
        $_SESSION["error"] = "パスワードが一致しません";
        header("Location: user_register.php");
        return;
    }
    $pdo = connectDB();

    $sql = "INSERT INTO users (username, passwd, group_id) VALUES(:username, :passwd, :group_id)";
      $statement = $pdo->prepare($sql);
      $result = $statement->execute([
        ':username' => $username,
        ':passwd' => crypt($passwd),
        ':group_id' => $group_id
      ]);


    if (!$result) {
        die('Database Error');
    }

    // セッションにメッセージを格納
    $_SESSION["success"] = "登録が完了しました。ログインしてください。";
    // ログイン画面に遷移
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8" />
	<title>ユーザー登録</title>

<link rel="stylesheet" href="./mystore.css">
</head>
<body>
	<div class="container">
    <section id="content">


    <!-- セッション変数(successやerror)に値が入っている場合の処理
    ログインに成功した．または失敗した理由を表示 -->
      <!-- Success Message -->
      <?php if(!empty($_SESSION['success'])): ?>
          <div class="alert alert-success" role="success">
            <!-- メッセージを表示 -->
              <pre><?php echo $_SESSION['success']; ?></pre>
            <!-- セッション変数 succcess の値を空に -->
              <?php $_SESSION['success'] = null; ?>
          </div>
      <?php endif; ?>
      <!-- Error Message -->
      <?php if(!empty($_SESSION['error'])): ?>
          <div>
            <!-- メッセージを表示 -->
              <pre><?php echo $_SESSION['error']; ?></pre>
            <!-- セッション変数 succcess の値を空に -->
              <?php $_SESSION['error'] = null; ?>
          </div>
      <?php endif; ?>

    <form action="" method="POST">
      <h1>
        MusicFriend 会員登録
      </h1>
      <div>
        <label>ユーザー名</label>
            <input type="text" name="username"  placeholder="青山太郎" id="username"/>
            <br>
        <label>パスワード</label>
            <input type="password" name="passwd" id="password"/>
            <br>
        <label>パスワード再入力</label>
            <input type="password" name="passwd_confirmation" id="passwd_confirmation">
        <p>希望するコースを選択してください<br>
          <label><input type="checkbox" name="group_id" value="1">プロデューサー向けコース<br></label>
          <label><input type="checkbox" name="group_id" value="2">動画投稿者向けコース<br></label>
          <label><input type="checkbox" name="group_id" value="3">一般観賞向けコース<br></label>
          <!-- <input type="checkbox" name="group_id" value="1"> -->
        </p>
      </div>

        <input type="submit" value="登録">
  
    </form>
	</div>

</body>
</html>
