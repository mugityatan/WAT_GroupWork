<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>ユーザー追加ページ</title>
    </head>
    <body>
        <?php
            // 名前情報が送信されていれば
            if(isset($_POST["name"])){
                // セッション開始
                session_start();
                // db.phpを読み込み
                include_once('db.php');
                // addUserを実行し結果をセッション変数に保存
                $_SESSION["id"] = addUser($_POST["name"], $_POST["mail"], $_POST["pass"]);
                // upload.phpに移動
                header( "Location: upload.php" ) ;
                exit();
            }
        ?>
        <form action="" method="POST">
            <input type="text" name="name" placeholder="名前">
            <input type="text" name="mail" placeholder="メールアドレス">
            <input type="password" name="pass" placeholder="パスワード">
            <input type="submit" value="登録">
        </form>
        <div>
            <a href="index.html">トップページ</a>
        </div>
    </body>
</html>