#-*- coding:utf-8 -*-

import tkinter as tk
import netifaces
import subprocess
import os
import threading
import mysql.connector
import slackweb
from datetime import datetime

#データベース接続開始##################
conn = mysql.connector.connect(
	host='localhost',
	port='3306',
	user='root',
	password='passwd',
	database='EEmgmt'
)
#######################################



def main_gui():
	root = tk.Tk()
	screen_width = root.winfo_screenwidth()   #スクリーンサイズを取得
	screen_height = root.winfo_screenheight() #スクリーンサイズを取得
	root.title("入退出管理システム-メインメニュー")
	root.attributes("-fullscreen", True)
	#root.geometry("640x480")

	###ボタンサイズ計算###
	buttron_size = int(screen_width * 0.05357142857)
	###テキストサイズ計算###
	text_size = int(screen_width * 0.02868253968254)
	text_size2 = int(text_size / 2)
	
	def end():
	        root.quit()

	def ipadress():                    #ipアドレス取得関数
        	ip = netifaces.ifaddresses('br0')[netifaces.AF_INET][0]['addr']
        	#print(ip)
        	return ip

	def checkin():
	        root.destroy()
        	checkin_gui()
	        return


	lbl = tk.Label(text='入退出管理システム',font=("",text_size))
	lbl.place(x=2, y=2)
	text_lo = text_size + 20
	lbl_ip = tk.Label(text="IPアドレスは"+ipadress()+"です。",font=("",text_size2))
	lbl_ip.place(x=2, y=text_lo)
	lbl2 = tk.Label(text='入室か退室を選択してください。',font=("",text_size2))
	text_lo  += text_size2 + 20 
	lbl2.place(x=2, y=text_lo)

	checkin = tk.Button(root,text="入室\nにゅうしつ",command=checkin,height=4,width=9,bg="#7fbfff",activebackground="#7fbfff",font=("",buttron_size))
	checkout  = tk.Button(root,text="退室\nたいしつ",command=end ,height=4,width=9,bg="#ffff7f",activebackground="#ffff7f",font=("",buttron_size))

	#配置
	checkin.pack(padx=50, side = 'left')
	checkout.pack(padx=50, side = 'right')
	root.mainloop()

def checkin_gui():
	###################別スレッドで実行する処理#####
	def read_id():
		center_y = int(screen_height / 2)   #解像度計算
		result = subprocess.check_output(["sudo", "python","/home/pi/EEmgmt/gui/read-id.py"])
		result = str(result)
		id_check = ('ID=' in result)
		error_check = ('Unsupported_card' in result)
		timeout_check = ('Time_out' in result)
		if id_check == True: 
			idm = result.find('ID=')
			idm += 3 
			idm_end = idm + 16
			id_card = result[idm:idm_end]
			id_card = "'" + id_card + "'"
			cur = conn.cursor()
			sql = 'SELECT name, slack  FROM Basic_info WHERE idm =' + id_card
			cur.execute(sql)
			result = cur.fetchall()
			if not result:
				name = 'カードが登録されていません'
			else:
				name = result[0][0] + 'さん こんにちは'
			cur.close()
			conn.close()
			slack = slackweb.Slack(url= result[0][1] ) #slack通知--> URL指定
			slack.notify(text= datetime.now().strftime('%m月%d日 %H時%M分    ')+result[0][0] + "さんが入室しました。")  #slack通知実行
			lbl_status = tk.Label(text=name,font=("",text_size))
			lbl_status.place(x=2, y=center_y)
		elif error_check== True:
			id_card = '非対応のカードです'
			lbl_status = tk.Label(text= id_card ,font=("",text_size))
			lbl_status.place(x=2, y=center_y)
		elif timeout_check == True:
			id_card = 'タイムアウトです'
			lbl_status = tk.Label(text= id_card ,font=("",text_size))
			lbl_status.place(x=2, y=center_y)
		else:
			id_card = 'その他のエラーです'
			lbl_status = tk.Label(text= id_card ,font=("",text_size))
			lbl_status.place(x=2, y=center_y)
	##############################################

	go_read  = threading.Thread(target = read_id)

	root = tk.Tk()
	######スクリーンサイズ計算#####
	screen_width = root.winfo_screenwidth()   #スクリーンサイズを取得
	screen_height = root.winfo_screenheight() #スクリーンサイズを取得
	text_size = int(screen_width * 0.02868253968254)
	text_size2 = int(text_size / 2)
	root.title("入退出管理システム-入室")
	#root.geometry("800x800")
	root.attributes("-fullscreen", True)
	lbl = tk.Label(text='入退出管理システム ---入室---',font=("",text_size))
	lbl.place(x=2, y=2)
	lbl2 = tk.Label(text='カードを読み取り部にタッチしてください。',font=("",text_size2))
	text_lo = text_size + 30
	lbl2.place(x=2, y=text_lo)

	def end():
		root.quit()

	exit = tk.Button(root,text="exit",command=end)
	exit.pack()


	read_id_thread = threading.Thread(target=read_id)
	go_read.start()

	root.mainloop()
	return


main_gui()
