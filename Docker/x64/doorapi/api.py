from flask import Flask
import os, requests, random, json, mysql.connector

app = Flask(__name__)

mysql_password = os.environ.get('MYSQL_PASSWORD')

@app.route('/')
def index():
    pass
    return "OK"


app.run(debug=False, host='0.0.0.0', port=9000, threaded=True)
