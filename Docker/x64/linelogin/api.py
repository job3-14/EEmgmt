import flask

app = flask.Flask(__name__)

@app.route('/')
def index():
    return "Hello, World!"

app.run(debug=False, host='0.0.0.0', port=10000)
