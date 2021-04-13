<?php
require_once('./functions.php');
session_start();
// POSTリクエストの場合
/*
 * 普通にアクセスした場合: GETリクエスト
 * 登録フォームからSubmitした場合: POSTリクエスト
 */
// POSTリクエストの場合
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 送られた値を取得
    $username = $_POST['username'];
    $passwd = $_POST['passwd'];

    /**
     * 入力値チェック
     */
    // 未入力の項目があるか
    if (empty($username) || empty($passwd)) {
        $_SESSION["error"] = "入力されていない項目があります";
        header("Location: login.php");
        return;
    }

    /**
     * 認証
     */
    $db = connectDb();
    // 送られたusernameを使ってDBを検索する
    $sql_1 = 'SELECT * FROM users WHERE username = :username';
    $statement_1 = $db->prepare($sql_1);
    $statement_1->execute(['username' => $username]);
    $user = $statement_1->fetch(PDO::FETCH_ASSOC);
    if ($user === false) {
      $_SESSION["error"] = "ログインできませんでした";
      header("Location: login.php");
      return;
    }

    // ユーザーが取得できなかったら、それは入力されたusernameが間違っているということ
    if (!$user) {
        $_SESSION["error"] = "入力した名前に誤りがあります。";
        header("Location: login.php");
        return;
    }

    // パスワードとパスワードが一致しているか
    if (crypt($passwd, $user['passwd']) !== $user['passwd']) {
        $_SESSION["error"] = "入力したパスワードに誤りがあります。";
        header("Location: login.php");
        return;
    }

    // ログイン処理
    // ユーザー情報をセッションに格納する
    $_SESSION["user"]["id"] = $user['id'];
    $_SESSION["user"]["username"] = $user['username'];

    // $_SESSION["success"] = "ログインしました。";


    $group_id = $user["group_id"];

    // if($group_id === "1"){
    //   header("Location: listup.php");
    // }
    if ($group_id === "2") {
      header("Location: post.php");
      return;
    }else {
      header("Location: listup.php");
      return ;
    }
    // var_dump($user);
    // var_dump($group_id);

}

?>

<html lang="ja">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./mystore.css">
</head>
<body>
<div class="container">
  <section id="content">


    	<div id="all">

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

    <form action="" method="post">
        <h1>ログイン</h1>
        <div>
            <label for="username-input">ユーザー名</label>
            <input type="text" name="username" id="username" placeholder="青山太郎">
        </div>
        <div>
            <label for="password-input">パスワード</label>
            <input type="password" name="passwd" id="password" placeholder="">
        </div>
        <input type="submit" value="ログイン">
    </form>

</div>
</body>
</html>
