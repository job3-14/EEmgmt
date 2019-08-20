import wiringpi as pi
import time, nfc,requests, json, os
class Door:
    def __init__(self):
        self.servo_pin = 18
        self.url = "http://%s:9000" % os.environ.get('SERVER_IP')
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
        move_deg = int(0)
        pi.pwmWrite( self.servo_pin, move_deg )

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




main = Door()
main.readidm()
