import subprocess
subprocess.check_output([' echo none > /sys/class/leds/led0/trigger'],shell = True)
subprocess.check_output(['echo 1 > /sys/class/leds/led0/brightness'],shell = True)
