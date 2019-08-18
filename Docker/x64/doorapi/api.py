from flask import Flask
import os, requests, random, json, mysql.connector

app = Flask(__name__)

mysql_password = os.environ.get('MYSQL_PASSWORD')

@app.route('/')
def index():
    #データベース接続開始##################
    conn = mysql.connector.connect(
    	host='db',
    	port='3306',
    	user='root',
    	password=mysql_password,
    	database='EEmgmt'
    )
    conn.ping(reconnect=True) #自動再接続
    cur = conn.cursor() #操作用カーソルオブジェクト作成
    #######################################
    
    return "OK"


app.run(debug=False, host='0.0.0.0', port=9000, threaded=True)
