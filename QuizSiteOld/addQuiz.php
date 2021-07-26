<!-- クイズを追加してもらうページ -->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>クイズ追加ページ</title>
    </head>
    <body>
        <?php
            // クイズ情報が送信されていれば
            if(isset($_POST["question"]) && isset($_POST["answer"])){
                // セッション開始
                session_start();
                // db.phpを読み込み
                include_once('db.php');
                // addQuizを実行し結果をセッション変数に保存
                $_SESSION["id"] = addQuiz($_POST["key1"], $_POST["question"], $_POST["answer"]);
                // upload.phpに移動
                // header( "Location: upload.php" ) ;
                exit();
            }
        ?>
        <form action="" method="POST">
            <select name="key">
                <option value=1>記述問題</option>
                <option value=2>選択問題</option>
            </select><br>
            <input type="text" name="question" placeholder="問題"><br>
            <input type="text" name="answer" placeholder="答え">
            <input type="submit" value="登録">
        </form>
        <div>
            <a href="index.html">トップページ</a>
        </div>
    </body>
</html>