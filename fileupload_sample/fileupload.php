<?php
//[FileUploadCheck--START--]
if (isset($_FILES["upfile"] ) && $_FILES["upfile"]["error"] ==0 ) {
    //
    $file_name = $_FILES["upfile"]["name"];
    //
    $tmp_path  = $_FILES["upfile"]["tmp_name"];
    //
    $extension = pathinfo($file_name, PATHINFO_EXTENSION);
    //
    $file_name = date("YmdHis").md5(session_id()) . "." . $extension;

    // FileUpload [--Start--]
    $img="";
    $file_dir_path = "upload/".$file_name;
    if ( is_uploaded_file( $tmp_path ) ) {
        if ( move_uploaded_file( $tmp_path, $file_dir_path ) ) {

            chmod( $file_dir_path, 0644 );//ファイルの権限を設定

            require_once("../funcs.php");
            //2. DB接続します
            $pdo = db_conn();
            $sql = "INSERT INTO gs_img_table(id,img)VALUES(null,:img)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':img', $file_name, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
            $status = $stmt->execute();

            //４．データ登録処理後
            if ($status == false) {
                sql_error($stmt);
            } else {
                $img = '<img src="'.$file_dir_path.'">';
            }

        } else {
            // echo "Error:アップロードできませんでした。";
        }
    }


 }else{
     $img = "画像が送信されていません";
 }
 //[FileUploadCheck--END--] 


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>アップロード画面サンプル</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
   <main>
    <!-- ヘッダー -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="file_view.php">写真一覧</a></div>
                <div class="navbar-header"><a class="navbar-brand" href="index.html">写真アップロード</a></div>
            </div>
        </nav>
    </header>
    <!-- ヘッダー -->
    <?php echo $img; ?>
</main>
</body>
</html>