<?php
  require_once('./functions.php');
  session_start();
  $pdo = connectDB();

  redirectIfNotLogin();
  $id = $_SESSION['user']['id'];
  $username = $_SESSION['user']['username'];

if ($_SERVER["REQUEST_METHOD"]==="POST") {

    $message = $_POST['message'];
    $receive_id = $_POST['recieve_id'];
    $sql = "INSERT INTO chats (message, send_id, receive_id) VALUES(:message, :send_id, :receive_id)";
    $statement = $pdo->prepare($sql);
    $result = $statement->execute([
      ':message' => $message,
      ':send_id' => $id,
      ':receive_id' => $receive_id
    ]);
    // header("Location: chats.php");
}
$receive_id = $_GET['id'];
$sql = 'SELECT * FROM chats';
$statement = $pdo->query($sql);
$statement->execute();
$chats = $statement->fetchAll();

 ?>
 <!DOCTYPE html>
 <html lang="ja">
 <head>
   <meta charset="UTF-8" />
   <title>aki</title>
   <!-- <link rel="stylesheet" href="./my.css"> -->
   <!-- BootstrapのCSS読み込み -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- jQuery読み込み -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- BootstrapのJS読み込み -->
<script src="js/bootstrap.min.js"></script>
 </head>
 <body>
 <div id="all">
      <div>
      <h3>投稿一覧</h3>
      <form action="" method="post">
          <p>メッセージ:<input type="text" name="message" size="100" maxlength="100" value=""></p>
          <input type="hidden" name="recieve_id" value="<?php echo $receive_id ;?>">
          <input type="submit" value="送信">
      </form>

      <table border="2">
        <thead>
          <tr>
            <th>メッセージ</th>
            <th>送信者</th>
            <th>受信者</th>
            </tr>
        </thead>
        <tbody>
          <?php foreach($chats as $chat): ?>
            <tr>
              <td><?php echo h($chat['message']);?></td>
              <td><?php echo h($chat['send_id']); ?></td>
              <td><?php echo h($chat['receive_id']); ?></td>
            </tr>
          <?php endforeach; ?>

          <p>検索フォームは
          <a href="listup.php">こちら</a>
          </p>
        </tbody>
      </table>
     </div>

 </div>
 </body>
 </html>
