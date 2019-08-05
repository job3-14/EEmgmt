from flask import Flask, session, request
import os, requests, random, json, jwt

app = Flask(__name__)
app.secret_key = os.urandom(24)

channel_id="1605802644"
channel_secret="3cf738681ede4bf72107443fdb54565a"


@app.route('/')
def index():
    return 'hello'

@app.route('/apply')
def apply():
    state = str(random.randint(100000000000000,9999999999999999))
    session['state'] = state
    url = "https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=1605802644&redirect_uri=https://job314.tokyo/apply2&state="+state+"&bot_prompt=aggressive&scope=openid%20email"
    return url

@app.route('/apply2',methods=["GET", "POST"])
def apply2():
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
    "redirect_uri": "https://job314.tokyo/apply2",
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
    print(decoded_id_token["sub"])
    print(decoded_id_token["email"])

    return id_token


app.run(debug=False, host='0.0.0.0', port=10000)
