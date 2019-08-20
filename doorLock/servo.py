import wiringpi as pi
import time
servo_pin = 18
CYCLE = 20
RANGE = 2000

clock = int( 19.2 / float(RANGE) * CYCLE * 1000 )

pi.wiringPiSetupGpio()
pi.pinMode( servo_pin, pi.GPIO.PWM_OUTPUT )
pi.pwmSetMode( pi.GPIO.PWM_MODE_MS )
pi.pwmSetRange( RANGE )
pi.pwmSetClock( clock )

move_deg = int(150)
pi.pwmWrite( servo_pin, move_deg )
print(move_deg)
time.sleep(1)
move_deg = int(0)
pi.pwmWrite( servo_pin, move_deg )
