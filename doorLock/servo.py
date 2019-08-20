import wiringpi as pi
import time
class Door:
    def __init__():
        self.servo_pin = 18
        self.CYCLE = 20
        self.RANGE = 2000
        self.clock = int( 19.2 / float(RANGE) * CYCLE * 1000 )
        self.pi.wiringPiSetupGpio()
        self.pi.pinMode( servo_pin, pi.GPIO.PWM_OUTPUT )
        self.pi.pwmSetMode( pi.GPIO.PWM_MODE_MS )
        self.pi.pwmSetRange( RANGE )
        self.pi.pwmSetClock( clock )

move_deg = int(150)
pi.pwmWrite( servo_pin, move_deg )
print(move_deg)
time.sleep(1)
move_deg = int(0)
pi.pwmWrite( servo_pin, move_deg )
