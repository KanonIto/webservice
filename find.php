<?php
  require_once('./functions.php');
  session_start();

	if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$people_tag = $_POST['people_tag'];
	$sex_tag = $_POST['sex_tag'];
	$music_tag = $_POST['music_tag'];


	$db = connectDb();
	// 送られたusernameを使ってDBを検索する
	$sql = 'SELECT * FROM movies WHERE people_tag = :people_tag AND sex_tag = :sex_tag AND music_tag = :music_tag';
	$statement = $db->prepare($sql);
	$result = $statement->execute([
		':people_tag' => $people_tag,
		':sex_tag' => $sex_tag,
		':music_tag' => $music_tag
		]);
	$find = $statement->fetchAll();
	if ($find === false) {
		$_SESSION["error"] = "残念１";
		// header("Location: find.php");
		return;
	}

	// // ユーザーが取得できなかったら、それは入力されたusernameが間違っているということ
	// if (!$people_tag) {
	// 		$_SESSION["error"] = "残念２";
	// 		header("Location: find.php");
	// 		return;
	// }
	// if (!$sex_tag) {
	// 		$_SESSION["error"] = "残念3";
	// 		header("Location: find.php");
	// 		return;
	// }
	// if (!$music_tag) {
	// 		$_SESSION["error"] = "残念4";
	// 		header("Location: find.php");
	// 		return;
	// }
}	?>

	<!DOCTYPE html>
	<html lang="ja">
	<head>
		<meta charset="UTF-8" />
		<title>テスト</title>
    <link rel="stylesheet" href="./myscore.css">
	</head>
	<body>
		<div id="all">
	  <!-- 他のページからGETでアクセスした場合は，以下のみが表示される． -->
	    <h2>テスト</h2>

	        <form action="" method="post">
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
	            <input type="submit" value="検索">
	        </form>
	<?php
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
	echo $sql;
	}
	?>
	<table border="2">
		<thead>
			<tr>
				<th>ID</th>
				<th>タイトル</th>
				<th>URL</th>
				</tr>
		</thead>
		<tbody>
			<?php foreach($find as $find): ?>
				<tr>
					<td><?php echo h($article['user_id']);?></td>
					<td><?php echo h($article['title']); ?></td>
					<td><a href="<?php echo h($article['url']); ?>"><?php echo h($article['url']); ?></a></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>


	</body>
	</html>
