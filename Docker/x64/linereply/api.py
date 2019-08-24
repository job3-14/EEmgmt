# coding: utf-8
import os, sys, mysql.connector
from argparse import ArgumentParser

from flask import Flask, request, abort
from linebot import (
    LineBotApi, WebhookHandler
)
from linebot.exceptions import (
    InvalidSignatureError
)
from linebot.models import (
    MessageEvent, TextMessage, TextSendMessage, FollowEvent
)

app = Flask(__name__)

domain_name = os.environ.get('DOMAIN_NAME')
# get channel_secret and channel_access_token from your environment variable
channel_secret = os.environ.get('LINEAPI_SECRET')
channel_access_token = os.environ.get('LINEAPI_TOKEN')
if channel_secret is None:
    print('Specify LINE_CHANNEL_SECRET as environment variable.')
    sys.exit(1)
if channel_access_token is None:
    print('Specify LINE_CHANNEL_ACCESS_TOKEN as environment variable.')
    sys.exit(1)

line_bot_api = LineBotApi(channel_access_token)
handler = WebhookHandler(channel_secret)


@app.route("/callback", methods=['POST'])
def callback():
    # get X-Line-Signature header value
    signature = request.headers['X-Line-Signature']

    # get request body as text
    body = request.get_data(as_text=True)
    app.logger.info("Request body: " + body)

    # handle webhook body
    try:
        handler.handle(body, signature)
    except InvalidSignatureError:
        abort(400)

    return 'OK'

@handler.add(FollowEvent)
def handle_follow(event):
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
    cur.execute("SELECT EXISTS(SELECT userid FROM line WHERE userid = '%s');" % event.source.user_id)
    result = cur.fetchone()[0]
    cur.close()
    conn.close()
    if result==1:
        line_bot_api.reply_message(event.reply_token,TextSendMessage(text="このアカウントは連携済みです。連携を解除する場合は以下のリンクより認証してください。\n https://%s:8080/cancel" % domain_name))
    else:
        line_bot_api.reply_message(event.reply_token,TextSendMessage(text="このアカウントは連携していません。連携する場合は以下のリンクより認証してください。\n https://%s:8080/" % domain_name))

@handler.add(MessageEvent, message=TextMessage)
def message_text(event):

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
    cur.execute("SELECT EXISTS(SELECT userid FROM line WHERE userid = '%s');" % event.source.user_id)
    result = cur.fetchone()[0]
    cur.close()
    conn.close()
    if result==1:
        line_bot_api.reply_message(event.reply_token,TextSendMessage(text="このアカウントは連携済みです。連携を解除する場合は以下のリンクより認証してください。\n https://%s:8080/cancel" % domain_name))
    else:
        line_bot_api.reply_message(event.reply_token,TextSendMessage(text="このアカウントは連携していません。連携する場合は以下のリンクより認証してください。\n https://%s:8080/" % domain_name))

app.run(debug=False, host='0.0.0.0', port=5000)
