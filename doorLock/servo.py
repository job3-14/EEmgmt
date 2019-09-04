import wiringpi as pi
import RPi.GPIO as GPIO
import time, nfc,requests, json, os, threading, binascii
class Door:
    def __init__(self):
        self.servo_pin = 18
        self.door_pin = 21
        self.button_pin = 20
        self.ledGreen_pin = 16
        self.ledRed_pin = 12
        self.openPwm = 165
        self.closePwm = 250
        self.url = "http://%s:9000" % "192.168.1.98"
        GPIO.setmode(GPIO.BCM)
        GPIO.setup(self.ledGreen_pin,GPIO.OUT)
        GPIO.setup(self.ledRed_pin,GPIO.OUT)
        GPIO.output(self.ledGreen_pin,True)
        GPIO.output(self.ledRed_pin,True)
        GPIO.setup(self.servo_pin,GPIO.IN,pull_up_down=GPIO.PUD_UP)
        GPIO.setup(self.door_pin,GPIO.IN,pull_up_down=GPIO.PUD_UP)
        GPIO.setup(self.button_pin,GPIO.IN,pull_up_down=GPIO.PUD_UP)
        CYCLE = 20
        RANGE = 2000
        clock = int( 19.2 / float(RANGE) * CYCLE * 1000 )
        pi.wiringPiSetupGpio()
        pi.pinMode( self.servo_pin, pi.GPIO.PWM_OUTPUT )
        pi.pwmSetMode( pi.GPIO.PWM_MODE_MS )
        pi.pwmSetRange( RANGE )
        pi.pwmSetClock( clock )
        pi.pwmWrite( self.servo_pin, self.openPwm )
        time.sleep(1)
        pi.pwmWrite( self.servo_pin, self.closePwm )
        time.sleep(1)
        pi.pwmWrite( self.servo_pin, 0 )
        self.openDoorFrag = 0
        self.suica=nfc.clf.RemoteTarget("212F")
        self.suica.sensf_req=bytearray.fromhex("0000030000")
        thread1 = threading.Thread(target=self.status)
        thread2 = threading.Thread(target=self.readidm)
        thread3 = threading.Thread(target=self.button)
        thread4 = threading.Thread(target=self.openDoor)
        thread1.start()
        #thread2.start()
        thread3.start()
        thread4.start()
        GPIO.output(self.ledGreen_pin,False)
        self.readidm()


    def status(self):
        while True:
            button_st = GPIO.input(self.door_pin)
            if button_st == 1:
                self.status = "open"
            else:
                self.status = "close"
            time.sleep(0.5)

    def readidm(self):
        while True:
            time.sleep(0.5)
            with nfc.ContactlessFrontend("usb") as clf:
                target=clf.sense(self.suica,iterations=3,interval=1.0)
                while target:
                    tag=nfc.tag.activate(clf,target)
                    tag.sys=3
                    idm=binascii.hexlify(tag.idm)
                    idm = idm.decode()
                    headers = {"Content-Type":"application/json"}
                    payload = {"idm": idm}
                    authentication = requests.post(self.url, headers=headers,data=json.dumps(payload))
                    if authentication.text == "OK":
                        self.openDoorFrag = 1
                    else:
                        for i in range(6):
                            GPIO.output(self.ledRed_pin,True)
                            time.sleep(0.08)
                            GPIO.output(self.ledRed_pin,False)
                            time.sleep(0.08)
                        GPIO.output(self.ledRed_pin,True)
                    break

    def button(self):
        while True:
            GPIO.wait_for_edge(self.button_pin, GPIO.BOTH) #変化があるまで待機
            button_st = GPIO.input(self.button_pin)
            print(button_st)
            if button_st == 0:
                self.openDoorFrag = 1

    def openDoor(self):
        while True:
            while True:
                if self.openDoorFrag == 1:
                    break
                else:
                    time.sleep(0.3)
            GPIO.output(self.ledGreen_pin,False)
            GPIO.output(self.ledRed_pin,False)
            GPIO.output(self.ledGreen_pin,True)
            pi.pwmWrite(self.servo_pin,self.openPwm)   #ドアオープン処理
            time.sleep(7)
            while True:
                print(self.status)
                if self.status=="open":
                    time.sleep(0.5)
                else:
                    time.sleep(3)
                    pi.pwmWrite(self.servo_pin, self.closePwm)   #ドアクローズ
                    break
            GPIO.output(self.ledGreen_pin,False)
            GPIO.output(self.ledRed_pin,False)
            GPIO.output(self.ledRed_pin,True)
            time.sleep(1.5)
            pi.pwmWrite(self.servo_pin, 0)     #開放
            self.openDoorFrag = 0

main = Door()
