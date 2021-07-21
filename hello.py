from flask import Flask, render_template
app = Flask(__name__)

@app.route('/')
def hello():
    name = "Hello World"
    return render_template('hello.html', title='flask test', members=name)

@app.route('/good')
def good():
    name = "Good"
    return name

@app.route('/test')
def test():
    name = "Python test"
    return name

@app.route('/test2')
def test2():
    name = "Good test2"
    return name

## おまじない
if __name__ == "__main__":
    app.run(debug=True)