<!-- クイズに回答するページ -->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>クイズ解答ページ</title>

        <script src="js/vue.dev.js"></script>
        <script src="js/axios.min.js"></script>
    </head>
    <body>
        <?php
            // データベースからランダムにクイズを選択
            $quiz_num = end(quiz.id);
            $selectedQuizId = rand(1, $quiz_num);
            if(quiz.id==$selectedQuizId) {
                
            }
        ?>
        <section>
            <div v-for='quiz in quizzes'>
                <hr>
                ID：{{quiz.id}}<br>
                問題：{{quiz.question}}<br>
                答え：{{quiz.answer}}
                <hr>
            </div>
            <input type="text" name="answer" placeholder="答え">
            <input type="submit" value="送信">
        </section>
        <div>
            <a href="index.html">トップページ</a>
        </div>
        <script>
            new Vue({
                el: '#quiz',
                data: {
                    // クイズ格納用配列を空で用意
                    quizzes: []
                },
                // ページの読み込みが完了したら
                created: function(){
                    // getDataを実行
                    this.getData();
                },
                methods: {
                    // 読み込み完了直後に実行
                    getData: function(){
                        // browseQuizzes.phpを呼び出し情報を取得
                        axios.get('browseQuizzes.php')
                        // 結果をresに代入
                        .then( ( res ) => {
                            // res内のdataに結果JSONが入っているので中身を一つずつ取得
                            for(quiz of res.data){
                                // ペラ用配列に追加
                                this.quizzes.push(quiz);
                            }
                        } )
                        .catch( ( res ) => {
                            console.error( res );
                        } );
                    }
                }
            });
        </script>
    </body>
</html>