<?php
  require_once('./functions.php');
  session_start();

  redirectIfNotLogin();
  $id = $_SESSION['user']['id'];
  $username = $_SESSION['user']['username'];

  if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = $_POST['title'];
    $url = $_POST['url'];
    $people_tag = $_POST['people_tag'];
    $sex_tag = $_POST['sex_tag'];
    $music_tag = $_POST['music_tag'];


    $pdo = connectDB();

    $sql = "INSERT INTO movies (user_id, title, url, people_tag, sex_tag, music_tag) VALUES(:user_id, :title, :url, :people_tag, :sex_tag, :music_tag)";
    $statement = $pdo->prepare($sql);
    $result = $statement->execute([
      ':user_id' => $id,
      ':title' => $title,
      ':url' => $url,
      ':people_tag' => $people_tag,
      ':sex_tag' => $sex_tag,
      ':music_tag' => $music_tag

    ]);
    // header("Location: post.php");
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8" />
	<title>新規投稿</title>
<link rel="stylesheet" href="./myscore.css">
</head>
<body>
	<div id="all">
    <fieldset>
    <legend>動画投稿</legend>
        <form action="" method="post">
          <p>タイトル:<input type="text" name="title" size="50" maxlength="50" value=""></p>
          <p>URL:<input type="text" name="url" size="50" maxlength="50" value=""></p>
          <p>人数</p>
          <label><input type="checkbox" name="people_tag" value=1>ソロ<br></label>
          <label><input type="checkbox" name="people_tag" value=2>デュオ<br></label>
          <label><input type="checkbox" name="people_tag" value=3>トリオ<br></label>
          <label><input type="checkbox" name="people_tag" value=4>4人以上<br></label>
          <p>性別</p>
          <label><input type="checkbox" name="sex_tag" value=1>男性<br></label>
          <label><input type="checkbox" name="sex_tag" value=2>女性<br></label>
          <label><input type="checkbox" name="sex_tag" value=3>混合<br></label>
          <p>ジャンル</p>
          <label><input type="checkbox" name="music_tag" value=1>歌<br></label>
          <label><input type="checkbox" name="music_tag" value=2>ギター<br></label>
          <label><input type="checkbox" name="music_tag" value=3>ピアノ<br></label>
          <label><input type="checkbox" name="music_tag" value=4>ドラム<br></label>
          <input type="submit" value="送信">
        </form>
        <p>検索フォームは
        <a href="listup.php">こちら</a>
        </p>
      </fieldset>
	</div>

</body>
</html>
