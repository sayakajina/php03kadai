<?php
session_start();
require_once('funcs.php');
loginCheck();

//selsect.phpから処理を持ってくる
//1.外部ファイル読み込みしてDB接続(funcs.phpを呼び出して)
$pdo = db_conn();

//2.対象のIDを取得
$id = $_GET['id'];


//3．データ取得SQLを作成（SELECT文）
$stmt = $pdo->prepare("SELECT * FROM gs_user_table WHERE id =:id");
$stmt ->bindValue(':id',$id,PDO::PARAM_INT);
$status = $stmt->execute();

//4．データ表示
$view = '';
if ($status == false){
    $error = $stmt->errorInfo();
    exit("ErrorQuery:".$error[2]);
}else{
    $row = $stmt->fetch();//ここを追記！！
    
};
?>

<!-- 以下はindex.phpのHTMLをまるっと持ってくる -->
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ユーザーデータ更新</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
    <?php echo $_SESSION["name"]; ?>さん　
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="index.php">申込</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="index_user.php">ユーザーデータ登録</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="select_user.php">ユーザーデータ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="POST" action="update_user.php">
  <div class="jumbotron">
   <fieldset>
    <legend>データ更新</legend>
     <label>名前：<input type="text" name="name" value="<?= $row['name']?>"></label><br>
     <label>ログインID：<input type="text" name="lid" value="<?= $row['lid']?>"></label><br>
     <label>Login PW<input type="text" name="lpw" placeholder="変更あるときだけ入力"></label><br>
     <label>管理FLG：
          <?php if($row["kanri_flg"]=="0"){ ?>
              一般<input type="radio" name="kanri_flg" value="0" checked="checked">　
              管理者<input type="radio" name="kanri_flg" value="1">
          <?php }else{ ?>
              一般<input type="radio" name="kanri_flg" value="0">　
              管理者<input type="radio" name="kanri_flg" value="1" checked="checked">
          <?php } ?>
      </label><br>
      <label>退会FLG：
        <?php if($row["life_flg"]=="0"){ ?>
                  利用中<input type="radio" name="life_flg" value="0" checked="checked">　
                  退会<input type="radio" name="life_flg" value="1">
              <?php }else{ ?>
                  利用中<input type="radio" name="life_flg" value="0">　
                  退会<input type="radio" name="life_flg" value="1" checked="checked">
              <?php } ?>
      </label><br>
     <input type="hidden" name="id" value="<?= $row['id'] ?>">
     <input type="submit" value="更新">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>