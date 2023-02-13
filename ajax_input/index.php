<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Ajax:POSTデータ登録</title>
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
  
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
      <div class="container-fluid">
          <div class="navbar-header"><a class="navbar-brand" href="../index.php">トップページ</a></div>
      </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->

<div class="jumbotron">
  <fieldset>
  <form>
    <legend id = "free">広告案件申込フォーム</legend>
     <label>ユーザーID<input type="text" id="instaid"></label><br>
     <label>ユーザーネーム<input type="text" id="username"></label><br>
     <label>Email：<input type="text" id="email"></label><br>
     <label>申し込みプラン<select id="entry">
      <option value="函館周遊プラン">函館周遊プラン</option>
      <option value="小樽食旅プラン">小樽食旅プラン</option>
      <option value="那須塩原温泉プラン">那須塩原温泉プラン</option>
    </select></label><br>
  </form>
    <button id="btn">登録</button>
  </fieldset>
</div>

<!-- Main[End] -->

    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script>
        //登録ボタンをクリック
        $("#btn").on("click",function() {
            //Ajax送信開始
            $.ajax({
                type: "POST",
                url: "insert.php",
                data: {
                    instaid: $("#instaid").val(),
                    username: $("#username").val(),
                    email: $("#email").val(),
                    entry: $("#entry").val(),
                },
                dataType: "html",
                //通信成功時にsuccess内が実行される！
                success: function(data) {
                  if(data=="false"){
                    alert("エラー");
                  }else{
                    $("#instaid").val("");
                    $("#username").val("");
                    $("#email").val("");
                    $("#entry").val("");
                    $("#free").html("登録成功しました");
                  }
                }
            });

        });
    </script>

</body>
</html>
