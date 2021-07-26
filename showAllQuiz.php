<!-- データベースにある全てのクイズ情報を表示 -->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>サンプルページ</title>

        <script src="js/vue.dev.js"></script>
        <script src="js/axios.min.js"></script>
    </head>
    <body>
        <div id="quiz">
            <section>
                <h1>クイズを全て表示</h1>
            </section>
            <section>
                <div v-for='quiz in quizzes'>
                    <hr>
                    問題：{{quiz.question}}<br>
                    答え：{{quiz.answer}}
                    <hr>
                </div>
            </section>
        </div>
        <script>
            new Vue({
                el: '#quiz',
                data: {
                    // ペラ用配列を空で用意
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