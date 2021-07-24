<!-- データベースを扱う関数まとめ -->
<?php

    // エラーの扱い（デバッグ用・デフォルトでコメントアウト）
    function checkError($e){
        // エラーログファイルに出力
        //error_log(date('Y-m-d H:i:s')." Error:".$e->getMessage()."\n", 3, "db_error.log");
        // php内の呼び出した箇所に表示
        print("Error:".$e->getMessage());
    }

    // PDOを作成し返す
    function getPDO(){
        // sqlite接続
        $pdo = new PDO("mysql:dbname=team01;host=localhost;charset=utf8mb4", "wat2021", "1315Zoom");

        // SQL実行時にもエラーの代わりに例外を投げるように設定
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // 結果を常に連想配列形式で取得するように設定
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // 生成したPDOを返す
        return $pdo;
    }

    // // パスワードの暗号化
    // function encryptPass($user_name, $user_pass){
    //     // まず名前とパスを連結
    //     $encryptedPass = $user_name.$user_pass;
    //     // 1986回のストレッチング
    //     for($i = 0; $i < 1986; $i++){
    //         // 暗号化
    //         $encryptedPass = md5($encryptedPass);
    //         // 100回に一度ソルトを追加
    //         if($i % 100 == 0) $encryptedPass = md5($encryptedPass."TokyoUniversityOfTechnology");
    //     }
    //     // 結果を返す
    //     return $encryptedPass;
    // }

    // 新規クイズの追加
    function addQuiz($quiz_key, $quiz_question, $quiz_answer){
        try{
            // 結果用新id
            $newid = -1;

            // PDOを取得
            $pdo = getPDO();

            // トランザクション開始
            $pdo->beginTransaction();

            try {
                // クイズを追加するクエリ
                $sql = 'INSERT INTO quiz(key1, question, answer) VALUES (?, ?, ?)';

                // クエリ文字列を渡しステートメントの準備
                $stmt = $pdo->prepare($sql);

                // クエリにセットする値用配列
                $values = array($quiz_key, $quiz_question, $quiz_answer);

                // ステートメントに値をセットし実行
                $stmt->execute($values);
                
                // 挿入された行のidを取得
                $newid = $pdo->lastInsertId('id');

                // トランザクションを完了しコミット
                $pdo->commit();

            // エラーが発生したら
            }catch (Exception $e) {
                // トランザクションを取り消してロールバック
                $pdo->rollBack();
                // エラーを上位に投げる
                throw $e;
            }

        // エラーが発生したら
        }catch (PDOException $e){
            // エラー内容を送る
            checkError($e);
            // -1を出力し終了
            return -1;
        }

        // 新idを返す
        return $newid;
    }

    // クイズ情報を配列に格納し、〇〇をリターン
    function answerQuiz(){
        try{
            // PDOを取得
            $pdo = getPDO();

            // 参加者テーブルを参照しつつペラ一覧を取得するクエリ
            $sql = 'SELECT * FROM quiz';

            // クエリ文字列を渡しステートメントの準備
            $stmt = $pdo->prepare($sql);

            // ステートメントを実行
            $stmt->execute();

            // 結果用変数
            $quizzes;

            // 結果の行数分繰り返し
            foreach($stmt as $row){
                // クイズ情報をセット
                $quiz["id"] = $row["id"];
                $quiz["question"] = $row["question"];
                $quiz["answer"] = $row["answer"];
                $quizzes[] = $quiz;
            }

        // エラーが発生したら
        }catch (PDOException $e){
            // エラー内容を送る
            checkError($e);
            // 空文字を出力し終了
            return "";
        }

        // 結果を返す
        return json_encode($quizzes, JSON_UNESCAPED_UNICODE);
    }

    // 解答を正解か判定する
    // 多分ここでやらない方がいい
    function judgeAnswer() {
        
    }

    // // ユーザーIDを取得し返す
    // function browseUserID($user_mail, $user_pass){
    //     try{
    //         // PDOを取得
    //         $pdo = getPDO();

    //         // ユーザー情報を取得するクエリ
    //         $sql = 'SELECT * FROM applicant WHERE mail=? AND pass=?';

    //         // クエリ文字列を渡しステートメントの準備
    //         $stmt = $pdo->prepare($sql);

    //         // クエリにセットする値用配列
    //         $values = array($user_mail, encryptPass($user_mail, $user_pass));

    //         // 値を渡しステートメントを実行
    //         $stmt->execute($values);

    //         // 結果用変数
    //         $userID = -1;

    //         // 結果の行数分繰り返し
    //         foreach($stmt as $row){
    //             // 各値をセットし結果行を作成
    //             $userID = $row["id"];
    //         }

    //     // エラーが発生したら
    //     }catch (PDOException $e){
    //         // エラー内容を送る
    //         checkError($e);
    //         // 空文字を出力し終了
    //         return "";
    //     }

    //     // 結果を返す
    //     return $userID;
    // }

    // // 新規ペラの追加
    // function addPera($applicant_id, $title, $description){
    //     try{
    //         // 結果用新id
    //         $newid = -1;

    //         // PDOを取得
    //         $pdo = getPDO();

    //         // トランザクション開始
    //         $pdo->beginTransaction();

    //         try {
    //             // 作品を追加するクエリ
    //             $sql = 'INSERT INTO pera SET applicant_id=?, title=?, description=?';

    //             // クエリ文字列を渡しステートメントの準備
    //             $stmt = $pdo->prepare($sql);
                
    //             // クエリにセットする値用配列
    //             $values = array($applicant_id, $title, $description);
                
    //             // ステートメントに値をセットし実行
    //             $stmt->execute($values);
                
    //             // 挿入された行のidを取得
    //             $newid = $pdo->lastInsertId('id');

    //             // トランザクションを完了しコミット
    //             $pdo->commit();

    //         // エラーが発生したら
    //         }catch (Exception $e) {
    //             // トランザクションを取り消してロールバック
    //             $pdo->rollBack();
    //             // エラーを上位に投げる
    //             throw $e;
    //         }

    //     // エラーが発生したら
    //     }catch (PDOException $e){
    //         // エラー内容を送る
    //         checkError($e);
    //         // -1を出力し終了
    //         return -1;
    //     }

    //     // 新idを返す
    //     return $newid;
    // }

    // // 作品リストを取得し返す
    // function browseAllPera(){
    //     try{
    //         // PDOを取得
    //         $pdo = getPDO();

    //         // 参加者テーブルを参照しつつペラ一覧を取得するクエリ
    //         $sql = 'SELECT * FROM pera 
    //                 INNER JOIN applicant 
    //                 WHERE pera.applicant_id=applicant.id';

    //         // クエリ文字列を渡しステートメントの準備
    //         $stmt = $pdo->prepare($sql);

    //         // ステートメントを実行
    //         $stmt->execute();

    //         // 結果用変数
    //         $peras;

    //         // 結果の行数分繰り返し
    //         foreach($stmt as $row){
    //             // ペラ情報をセット
    //             $pera["applicant"] = $row["name"];
    //             $pera["title"] = $row["title"];
    //             $pera["description"] = $row["description"];
    //             $pera["pera"] = $row["applicant_id"].".jpg";
    //             $peras[] = $pera;
    //         }

    //     // エラーが発生したら
    //     }catch (PDOException $e){
    //         // エラー内容を送る
    //         checkError($e);
    //         // 空文字を出力し終了
    //         return "";
    //     }

    //     // 結果を返す
    //     return json_encode($peras, JSON_UNESCAPED_UNICODE);
    // }

    // // ペラの削除
    // function deletePera($applicant_id){
    //     try{
    //         // PDOを取得
    //         $pdo = getPDO();

    //         // ペラを削除するクエリ
    //         $sql = 'DELETE FROM pera WHERE applicant_id=?';

    //         // クエリ文字列を渡しステートメントの準備
    //         $stmt = $pdo->prepare($sql);
            
    //         // クエリにセットする値用配列
    //         $values = array($applicant_id);
            
    //         // ステートメントに値をセットし実行
    //         $stmt->execute($values);

    //     // エラーが発生したら
    //     }catch (PDOException $e){
    //         // エラー内容を送る
    //         checkError($e);
    //         // -1を出力し終了
    //         return -1;
    //     }

    //     // 結果を返す
    //     return "success";
    // }

?>