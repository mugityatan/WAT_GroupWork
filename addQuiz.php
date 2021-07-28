<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>クイズ追加ページ</title>
    </head>
    <body>
        <?php
            // 名前情報が送信されていれば
            if(isset($_POST["question"]) && isset($_POST["answer"])){
                // セッション開始
                session_start();
                // db.phpを読み込み
                include_once('db.php');
                // addUserを実行し結果をセッション変数に保存
                $_SESSION["id"] = addQuiz($_POST["question"], $_POST["answer"]);
                // upload.phpに移動
                header( "Location: index.html" ) ;
                exit();
            }
        ?>
        <form action="" method="POST">
            <input type="text" name="question" placeholder="問題">
            <input type="text" name="answer" placeholder="答え">
            <input type="submit" value="登録">
        </form>
        <div>
            <a href="index.html">トップページ</a>
        </div>
    </body>
</html>