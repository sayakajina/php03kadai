<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ユーザーデータ登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="login.php">ログイン</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="select_guest.php">データ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="POST" action="insert_guest.php">
  <div class="jumbotron">
   <fieldset>
    <legend>広告案件申込フォーム</legend>
     <label>ユーザーID<input type="text" name="instaid"></label><br>
     <label>ユーザーネーム<input type="text" name="username"></label><br>
     <label>Email：<input type="text" name="email"></label><br>
     <label>申し込みプラン<select name="entry">
      <option value="函館周遊プラン">函館周遊プラン</option>
      <option value="小樽食旅プラン">小樽食旅プラン</option>
      <option value="那須塩原温泉プラン">那須塩原温泉プラン</option>
    </select></label><br>
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>
