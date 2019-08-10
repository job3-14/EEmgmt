from flask import Flask, session, request, redirect
import os, requests, random, json, jwt, mysql.connector

app = Flask(__name__)
app.secret_key = os.urandom(24)

channel_id = os.environ.get('CHANNEL_ID')
channel_secret = os.environ.get('CHANNEL_SECREST')
callback_url = os.environ.get('CALLBACK_URL')

@app.route('/')
def index():
    state = str(random.randint(100000000000000,9999999999999999))
    session['state'] = state
    url = "https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id="+channel_id+"&redirect_uri="+callback_url+"&state="+state+"&bot_prompt=aggressive&scope=openid%20email"
    return redirect(url, code=302)

@app.route('/apply',methods=["GET", "POST"])
def apply():
    state = request.args.get("state")
    state2 = session.get('state')
    code = request.args.get("code")
    if not state == state2:
        return "操作エラーです"

    postUrl = 'https://api.line.me/oauth2/v2.1/token'
    headers ={"Content-Type": "application/x-www-form-urlencoded"}
    payload = {
    "grant_type":"authorization_code",
    "code": code,
    "redirect_uri": callback_url,
    "client_id": channel_id,
    "client_secret": channel_secret
    }
    postData = requests.post(postUrl, headers=headers,data=payload)
    postData = json.loads(postData.text)
    id_token = postData["id_token"]
    ###JWTデーコード
    decoded_id_token = jwt.decode(id_token,
                                  channel_secret,
                                  audience=channel_id,
                                  issuer='https://access.line.me',
                                  algorithms=['HS256'])

    #データベース接続開始##################
    conn = mysql.connector.connect(
    	host='db',
    	port='3306',
    	user='root',
    	password=os.environ.get('MYSQL_PASSWORD'),
    	database='EEmgmt'
    )
    conn.ping(reconnect=True) #自動再接続
    cur = conn.cursor() #操作用カーソルオブジェクト作成
    #######################################
    cur.execute('DELETE FROM line WHERE email = %s' % email)
    cur.execute("INSERT INTO line (email, userid) VALUES (%s, %s)" % (decoded_id_token["email"], decoded_id_token["sub"]))
    cur.close()
    conn.close()
    return "認証が完了しました。このページを閉じてください。"


app.run(debug=False, host='0.0.0.0', port=80, threaded=True)
