<?php
    // セッション開始
    session_start();
    // ログイン済みでなければ
    if(!isset($_SESSION["id"])){
        // index.htmlに移動
        header( "Location: index.html" ) ;
        exit();
    }
    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
        include_once('db.php');
        if(exif_imagetype($_FILES["image"]["tmp_name"]) != IMAGETYPE_JPEG){
            echo "jpegをアップロードしてください";
        }else if (move_uploaded_file ($_FILES["image"]["tmp_name"], "data/".$_SESSION["id"].".jpg")) {
            addPera($_SESSION["id"], $_POST["title"], $_POST["description"]);
            echo "アップロードしました。";
        } else {
            echo "ファイルをアップロードできません。";
        }
    } else {
        echo "ファイルが選択されていません。";
    }
?>

<!DOCTYPE html>
<html lang="ja">
    <body>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="image">
            <input type="text" name="title" placeholder="作品名">
            <input type="text" name="description" placeholder="説明">
            <input type="submit" value="upload">
        </form>
        <div>
            <a href="index.html">トップページ</a>
        </div>
    </body>
</html>