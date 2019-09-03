#-*- coding:utf-8 -*-
import tkinter as tk
import nfc, threading, requests, json, time, mysql.connector, os
import setting
from datetime import datetime, timedelta, timezone
import nfc
import binascii

class Gui():
    def __init__(self):
        #データベース接続開始##################
        self.conn = mysql.connector.connect(
        	host='db',
        	port='3306',
        	user='root',
        	password=setting.password(),
        	database='EEmgmt'
        )
        self.conn.ping(reconnect=True) #自動再接続
        #######################################
        self.root = tk.Tk()
        self.screen_width = self.root.winfo_screenwidth()   #スクリーンサイズを取得
        self.screen_height = self.root.winfo_screenheight() #スクリーンサイズを取得
        self.center_y = self.screen_height / 2
        self.buttron_size = int(self.screen_width * 0.05357142857)#ボタンサイズ計算
        self.text_size = int(self.screen_width * 0.02868253968254)#テキストサイズ計算
        self.text_size2 = int(self.text_size / 2)#テキストサイズ計算
        self.text_lo = self.text_size + self.text_size + 40 #テキスト位置計算
        self.root.title("入退出管理システム-メインメニュー")
        self.root.attributes("-fullscreen", True)
        self.jst = timezone(timedelta(hours=+9), 'JST')
        ###以下メインウィンドウ作成###
        lbl = tk.Label(text='入退出管理システム',font=("",self.text_size))
        lbl.place(x=2, y=2)
        lbl2 = tk.Label(text='入室か退室を選択してください。',font=("",self.text_size2))
        lbl2.place(x=2, y=self.text_lo)
        checkin = tk.Button(self.root,text="入室\nにゅうしつ",command=self.checkin,height=4,width=9,bg="#7fbfff",activebackground="#7fbfff",font=("",self.buttron_size))
        checkout  = tk.Button(self.root,text="退室\nたいしつ",command=self.checkout ,height=4,width=9,bg="#ffff7f",activebackground="#ffff7f",font=("",self.buttron_size))
        reservation = tk.Button(self.root,text="カード登録",command=self.reservation,width=10,height=10)
        checkin.pack(padx=50, side = 'left')
        checkout.pack(padx=50, side = 'right')
        reservation.place(x=self.screen_width-130,y=20)
        thread = threading.Thread(target=self.readidm)
        thread.setDaemon(True)
        thread.start()
        self.root.mainloop()

    def readidm(self):
        suica=nfc.clf.RemoteTarget("212F")
        suica.sensf_req=bytearray.fromhex("0000030000")
        while True:
            time.sleep(0.3)
            with nfc.ContactlessFrontend("usb") as clf:
                target=clf.sense(suica,iterations=3,interval=1.0)
                while target:
                    tag=nfc.tag.activate(clf,target)
                    tag.sys=3
                    idm=binascii.hexlify(tag.idm)
                    self.idmStatus = idm.decode()
                    time.sleep(0.3)
                    break

    def checkin(self):
        self.frag = "False"
        self.idmStatus = "waiting"
        self.sub = tk.Toplevel()
        self.sub.attributes("-fullscreen", True)
        lbl = tk.Label(self.sub,text='入退出管理システム ---入室---',font=("",self.text_size))
        lbl2 = tk.Label(self.sub,text='カードを読み取り部にタッチしてください。',font=("",self.text_size2))
        lbl.place(x=2, y=2)
        lbl2.place(x=2, y=self.text_lo)
        thread1 = threading.Thread(target=self.checkinProcessing)
        thread2 = threading.Thread(target=self.timeOut)
        thread3 = threading.Thread(target=self.fragTimer)
        thread1.setDaemon(True)
        thread2.setDaemon(True)
        thread3.setDaemon(True)
        thread1.start()
        thread2.start()
        thread3.start()
        self.sub.mainloop()


    def checkinProcessing(self):
        while True:
            if self.idmStatus == "waiting":
                if self.frag == "True":
                    time.sleep(0.5)
                    return
            else:
                break
        self.conn.ping(reconnect=True)
        cur = self.conn.cursor(dictionary=True)  #カーソル作成
        cur.execute("SELECT name FROM service_user WHERE idm = '%s';" % self.idmStatus)
        sqlresult = cur.fetchall()
        if sqlresult:
            self.result = sqlresult[0]["name"] + "さん こんにちは"
            self.frag = "True"
            date = datetime.now(self.jst).strftime('%Y-%m-%d %H:%M')
            cur.execute("INSERT INTO history (idm,type,date) VALUES ('%s','入室','%s');" % (self.idmStatus, date))
            cur.execute("DELETE FROM history WHERE date NOT IN (SELECT * FROM (SELECT date FROM history ORDER BY date DESC LIMIT 3000) AS v)")
            self.conn.commit()
            cur.close()
            self.sendmessage(self.idmStatus,"入室")
        else:
            self.result = "[エラー]このカードは登録されていません"
            self.frag = "True"

    def checkout(self):
        self.frag = "False"
        self.idmStatus = "waiting"
        self.sub = tk.Toplevel()
        self.sub.attributes("-fullscreen", True)
        lbl = tk.Label(self.sub,text='入退出管理システム ---退室---',font=("",self.text_size))
        lbl2 = tk.Label(self.sub,text='カードを読み取り部にタッチしてください。',font=("",self.text_size2))
        lbl.place(x=2, y=2)
        lbl2.place(x=2, y=self.text_lo)
        thread1 = threading.Thread(target=self.checkoutProcessing)
        thread2 = threading.Thread(target=self.timeOut)
        thread3 = threading.Thread(target=self.fragTimer)
        thread1.setDaemon(True)
        thread2.setDaemon(True)
        thread3.setDaemon(True)
        thread1.start()
        thread2.start()
        thread3.start()
        self.sub.mainloop()

    def checkoutProcessing(self):
        while True:
            if self.idmStatus == "waiting":
                if self.frag == "True":
                    time.sleep(0.5)
                    return
            else:
                break
        self.conn.ping(reconnect=True)
        cur = self.conn.cursor(dictionary=True)  #カーソル作成
        cur.execute("SELECT name FROM service_user WHERE idm = '%s';" % self.idmStatus)
        sqlresult = cur.fetchall()
        if sqlresult:
            self.result = sqlresult[0]["name"] + "さん お疲れさまでした。"
            self.frag = "True"
            date = datetime.now(self.jst).strftime('%Y-%m-%d %H:%M')
            cur.execute("INSERT INTO history (idm,type,date) VALUES ('%s','退室','%s');" % (self.idmStatus, date))
            cur.execute("DELETE FROM history WHERE date NOT IN (SELECT * FROM (SELECT date FROM history ORDER BY date DESC LIMIT 3000) AS v)")
            self.conn.commit()
            cur.close()
            idm = self.idmStatus
            self.sendmessage(idm,"退室")
        else:
            self.result = "[エラー]このカードは登録されていません"
            self.frag = "True"

    def reservation(self):
        self.frag = "False"
        self.idmStatus = "waiting"
        self.sub = tk.Toplevel()
        self.sub.attributes("-fullscreen", True)
        lbl = tk.Label(self.sub,text='入退出管理システム ---カード登録---',font=("",self.text_size))
        lbl2 = tk.Label(self.sub,text='カードを読み取り部にタッチしてください。',font=("",self.text_size2))
        lbl.place(x=2, y=2)
        lbl2.place(x=2, y=self.text_lo)
        thread1 = threading.Thread(target=self.reservationProcessing)
        thread2 = threading.Thread(target=self.timeOut)
        thread3 = threading.Thread(target=self.fragTimer)
        thread1.setDaemon(True)
        thread2.setDaemon(True)
        thread3.setDaemon(True)
        thread1.start()
        thread2.start()
        thread3.start()
        self.sub.mainloop()

    def reservationProcessing(self):
        while True:
            if self.idmStatus == "waiting":
                if self.frag == "True":
                    time.sleep(0.5)
                    return
            else:
                break                        #変数tsgを文字列型に変換
        self.conn.ping(reconnect=True)
        cur = self.conn.cursor(dictionary=True)  #カーソル作成
        cur.execute("SELECT name FROM service_user WHERE idm = '%s';" % self.idmStatus)
        sqlresult = cur.fetchall()
        if sqlresult:
            self.result = "[エラー]このカードは登録されています"
            self.frag = "True"
        else:
            cur.execute("SELECT COUNT(number) FROM reservation;")
            sqlresult = cur.fetchall()
            number = sqlresult[0]['COUNT(number)'] + 1
            cur.execute("INSERT INTO reservation (number,idm) VALUES (%s,'%s');" % (number, self.idmStatus))
            self.conn.commit()
            cur.close()
            self.result = "予約登録が完了しました。予約番号は"+str(number)+"です。"
            self.frag = "True"

    def timeOut(self):
        time.sleep(4)
        self.result = "[エラー]タイムアウトです"
        self.frag = "True"

    def fragTimer(self):
        while self.frag == 'False':
        	time.sleep(0.5)
        else:
            lbl_status = tk.Label(self.sub,text= self.result ,font=("",self.text_size))
            lbl_status.place(x=2, y=self.center_y)
            time.sleep(6)
            self.sub.destroy()

    def sendmessage(self,idm,message):
        self.conn.ping(reconnect=True)
        cur = self.conn.cursor(dictionary=True)  #カーソル作成
        cur.execute("SELECT * FROM service_user WHERE idm = '%s';" % idm)
        sqlresult = cur.fetchall()
        cur.close()
        date = datetime.now(self.jst).strftime('%m月%d日%H時%M分')
        url = "http://messages:5000/sendMessage"
        headers = {
            "Content-Type": "application/json",
        }
        if sqlresult[0]["notice"] == "slack":
            jsonlist = {"method":"slack"}
            if sqlresult[0]["address1"]:
                jsonlist["address1"] = sqlresult[0]["address1"]
            if sqlresult[0]["address2"]:
                jsonlist["address2"] = sqlresult[0]["address2"]
            if sqlresult[0]["address3"]:
                jsonlist["address3"] = sqlresult[0]["address3"]
            if sqlresult[0]["address4"]:
                jsonlist["address4"] = sqlresult[0]["address4"]
            if sqlresult[0]["address5"]:
                jsonlist["address5"] = sqlresult[0]["address5"]
            jsonlist["text"]=sqlresult[0]["name"]+"さんが"+date+"に"+message+"しました。"
            requests.post(url, headers=headers,data=json.dumps(jsonlist))

        if sqlresult[0]["notice"] == "email":
            jsonlist = {"method":"email"}
            if sqlresult[0]["address1"]:
                jsonlist["address1"] = sqlresult[0]["address1"]
            if sqlresult[0]["address2"]:
                jsonlist["address2"] = sqlresult[0]["address2"]
            if sqlresult[0]["address3"]:
                jsonlist["address3"] = sqlresult[0]["address3"]
            if sqlresult[0]["address4"]:
                jsonlist["address4"] = sqlresult[0]["address4"]
            if sqlresult[0]["address5"]:
                jsonlist["address5"] = sqlresult[0]["address5"]
            jsonlist["fromEmail"] = setting.from_email()
            jsonlist["mailUserid"] = setting.id_email()
            jsonlist["mailPassword"] = setting.pass_email()
            jsonlist["subject"] = message + "通知"
            jsonlist["text"]=sqlresult[0]["name"]+"さんが"+date+"に"+message+"しました。"
            requests.post(url, headers=headers,data=json.dumps(jsonlist))

        if sqlresult[0]["notice"] == "line":
            jsonlist = {"method":"line"}
            self.conn.ping(reconnect=True)
            cur = self.conn.cursor(dictionary=True)
            cur.execute("SELECT * FROM line WHERE email='%s';" % sqlresult[0]["mainEmail"])
            sqlresult2 = cur.fetchall()
            cur.close()
            jsonlist["lineToken"] = setting.lineapi_token()
            jsonlist["userid"] = sqlresult2[0]["userid"]
            jsonlist["text"]=sqlresult[0]["name"]+"さんが"+date+"に"+message+"しました。"
            requests.post(url, headers=headers,data=json.dumps(jsonlist))

main = Gui()
