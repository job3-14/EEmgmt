import wiringpi as pi
import RPi.GPIO as GPIO
import time, nfc,requests, json, os, threading
class Door:
    def __init__(self):
        self.servo_pin = 18
        self.door_pin = 21
        self.url = "http://%s:9000" % "192.168.1.98"
        GPIO.setmode(GPIO.BCM)
        GPIO.setup(self.servo_pin,GPIO.IN,pull_up_down=GPIO.PUD_UP)
        GPIO.setup(self.door_pin,GPIO.IN,pull_up_down=GPIO.PUD_UP)
        CYCLE = 20
        RANGE = 2000
        clock = int( 19.2 / float(RANGE) * CYCLE * 1000 )
        pi.wiringPiSetupGpio()
        pi.pinMode( self.servo_pin, pi.GPIO.PWM_OUTPUT )
        pi.pwmSetMode( pi.GPIO.PWM_MODE_MS )
        pi.pwmSetRange( RANGE )
        pi.pwmSetClock( clock )
        move_deg = int(150)
        pi.pwmWrite( self.servo_pin, move_deg )
        time.sleep(1)
        move_deg = int(250)
        pi.pwmWrite( self.servo_pin, move_deg )
        time.sleep(1)
        move_deg = int(0)
        pi.pwmWrite( self.servo_pin, move_deg )
        thread1 = threading.Thread(target=self.status)
        thread2 = threading.Thread(target=self.readidm)
        thread1.start()
        thread2.start()


    def status(self):
        button_st = GPIO.input(self.door_pin)
        if button_st == 1:
            self.status = "open"
        else:
            self.status = "close"
        while True:
            GPIO.wait_for_edge(self.door_pin, GPIO.BOTH) #変化があるまで待機
            button_st = GPIO.input(self.door_pin)
            if button_st == 1:
                self.status = "open"
            else:
                self.status = "close"



    def readidm(self):
        clf = nfc.ContactlessFrontend('usb')
        tag = clf.connect(rdwr={'on-connect': self.outputIdm })
        clf.close()

    def outputIdm(self,tag):
        tag = str(tag)                        #変数tsgを文字列型に変換
        id_check = ('ID=' in tag)             #対応カードかどうか確認
        if id_check == True:                  #対応カードなら実行
            idm = tag.find('ID=')  + 3             #idのインデックスを検索
            idm_end = idm + 16         #idの終了インデックスを指定
            result_idm = tag[idm:idm_end]           #idを出力
            headers = {"Content-Type":"application/json"}
            payload = {"idm": result_idm}
            authentication = requests.post(self.url, headers=headers,data=json.dumps(payload))
            if authentication.text == "OK":
                self.openDoor()

    def openDoor(self):
        pi.pwmWrite(self.servo_pin, 150)   #ドアオープン処理
        time.sleep(7)
        while True:
            if self.status=="open":
                time.sleep(0.5)
            else:
                time.sleep(3)
                pi.pwmWrite(self.servo_pin, 250)   #ドアクローズ
                break
        time.sleep(1.5)
        pi.pwmWrite(self.servo_pin, 0)     #開放

main = Door()
