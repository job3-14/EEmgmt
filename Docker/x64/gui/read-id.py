# -*- coding: utf-8 -*-
import nfc
import threading
import time
import sys

frag = 'False'
#global frag

def read(tag):
	tag = str(tag)                              #変数tsgを文字列型に変換
	id_check = ('ID=' in tag)             #対応カードかどうか確認
	if id_check == True:                   #対応カードなら実行
		idm = tag.find('ID=')               #idのインデックスを検索
		#idm += 3                                #id本体の開始インデックスを指定
		idm_end = idm + 16  + 3           #idの終了インデックスを指定
		print(tag[idm:idm_end])         #idを出力
	else:                                          #非対応カードの場合実行
		print('Unsupported_card')     #エラーメッセージを出力
	global frag
	frag = 'True'

	return

def read_start():
        clf = nfc.ContactlessFrontend('usb')                    #nfcpyドキュメントを参照
        tag = clf.connect(rdwr={'on-connect': read })       #nfcpyドキュメントを参照

def time_out():
	time.sleep(5)  #待機時間（タイムアウト）
	print("Time_out")
	global frag
	frag = 'True'
	return


read_thread = threading.Thread(target=read_start)
read_thread.setDaemon(True)
read_thread.start()

time_out_thread = threading.Thread(target=time_out)
time_out_thread.setDaemon(True)
time_out_thread.start()

while frag == 'False':
	time.sleep(0.5)
else:
	sys.exit()

