<?php
  require_once('./functions.php');
  session_start();
  redirectIfNotLogin();
  $id = $_SESSION['user']['id'];
  $username = $_SESSION['user']['username'];

  // DB接続
  $pdo = connectDB();
if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $people_tag = (int)$_POST['people_tag'];
	$sex_tag = (int)$_POST['sex_tag'];
	$music_tag = (int)$_POST['music_tag'];
  if ($_POST["people_tag"]) {
    if ($_POST["sex"]) {
        if ($_POST["music_tag"]) {
            //  p and s and m
            	$sql = 'SELECT * FROM movies WHERE people_tag = :people_tag AND sex_tag = :sex_tag AND music_tag = :music_tag';
              $statement = $pdo->prepare($sql);
              $statement->execute([
                ':people_tag' => $people_tag,
                ':sex_tag' => $sex_tag,
                ':music_tag' => $music_tag
                ]);
        } else {
            //  p and s
            	$sql = 'SELECT * FROM movies WHERE people_tag = :people_tag AND sex_tag = :sex_tag';
              $statement = $pdo->prepare($sql);
              $statement->execute([
                ':people_tag' => $people_tag,
                ':sex_tag' => $sex_tag
                ]);
        }
    } else {
        if ($_POST["music_tag"]) {
            //  p and m
            	$sql = 'SELECT * FROM movies WHERE people_tag = :people_tag AND music_tag = :music_tag';
              $statement = $pdo->prepare($sql);
              $statement->execute([
                ':people_tag' => $people_tag,
                ':music_tag' => $music_tag
                ]);
        } else {
            //  p
            	$sql = 'SELECT * FROM movies WHERE people_tag = :people_tag';
              $statement = $pdo->prepare($sql);
              $statement->execute([
                ':people_tag' => $people_tag
              ]);
        }
    }
} else {
    if ($_POST["sex_tag"]) {
        if ($_POST["music_tag"]) {
            //  s and m
            	$sql = 'SELECT * FROM movies WHERE sex_tag = :sex_tag AND music_tag = :music_tag';
              $statement = $pdo->prepare($sql);
              $statement->execute([
                ':sex_tag' => $sex_tag,
                ':music_tag' => $music_tag
                ]);
        } else {
            //  s
            	$sql = 'SELECT * FROM movies WHERE sex_tag = :sex_tag';
              $statement = $pdo->prepare($sql);
              $statement->execute([
              ':sex_tag' => $sex_tag
              ]);
        }
    } else {
        if ($_POST["music_tag"]) {
            //  m
            	$sql = 'SELECT * FROM movies WHERE music_tag = :music_tag';
              $statement = $pdo->prepare($sql);
              $statement->execute([
                ':music_tag' => $music_tag
                ]);
        } else {
            // all
            	$sql = 'SELECT * FROM movies';
              $statement = $pdo->prepare($sql);
              $statement->execute([
                ':people_tag' => $people_tag,
                ':sex_tag' => $sex_tag,
                ':music_tag' => $music_tag
                ]);
        }
    }
}
} else {
  $sql = 'SELECT * FROM movies';
  $statement = $pdo->query($sql);
  // プレースメントフォルダが無いので，実行の表記が簡単
  $statement->execute();
  // $articles 連想配列に指定した記事が複数入っている状態↓
}
  $articles = $statement->fetchAll();

  $_SESSION["movies"]["user_id"] = $movies['id'];

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <!-- <link rel="stylesheet" href="./mystore.css"> -->
  <title>aki</title>

</head>
<body>
<div id="all">

     <div>
     <h3>投稿一覧</h3>
     <form action="" method="post">
       <p>人数</p>
       <label><input type="radio" name="people_tag" value=1>ソロ</label>
       <label><input type="radio" name="people_tag" value=2>デュオ</label>
       <label><input type="radio" name="people_tag" value=3>トリオ</label>
       <label><input type="radio" name="people_tag" value=4>4人以上<br></label>
       <p>性別</p>
       <label><input type="radio" name="sex_tag" value=1>男性</label>
       <label><input type="radio" name="sex_tag" value=2>女性</label>
       <label><input type="radio" name="sex_tag" value=3>混合<br></label>
       <p>ジャンル</p>
       <label><input type="radio" name="music_tag" value=1>歌</label>
       <label><input type="radio" name="music_tag" value=2>ギター</label>
       <label><input type="radio" name="music_tag" value=3>ピアノ</label>
       <label><input type="radio" name="music_tag" value=4>ドラム<br></label>
         <input type="submit" value="検索">
     </form>
     <br>

     <table border="2">
       <thead>
         <tr>
           <th>ID</th>
           <th>タイトル</th>
           <th>URL</th>
           </tr>
       </thead>
       <tbody>
         <?php foreach($articles as $article): ?>
           <tr>
             <td><a href="chats.php?id=<?php echo $article['user_id'] ?>"><?php echo h($article['user_id']);?></a></td>
             <td><?php echo h($article['title']); ?></td>
             <td><a href="<?php echo h($article['url'])?>"><?php echo h($article['url']); ?></a></td>
           </tr>
         <?php endforeach; ?>
       </tbody>
     </table>
    </div>

</div>
</body>
</html>
